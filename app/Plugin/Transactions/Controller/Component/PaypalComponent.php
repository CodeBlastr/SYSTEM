<?php
/**
 * Paypal Direct Payment API Component class file.
 */
App::import('Vendor','paypal' ,array('file'=>'paypal/paypal.php'));
class PaypalComponent extends Object{

	var $paysettings = array();
	var $response = array();
	var $payInfo = array();
	var $recurring = false;

	// set recurring value default is false
	function recurring($val = false) {
		$this->recurring = $val;
	}

	function initialize(&$controller, $settings=array()) {
		if(defined('__ORDERS_PAYPAL')) {
            $this->paysettings = unserialize(__ORDERS_PAYPAL);
		}
	}

	/*
	*function chainedPayment receive two params
	* @params $data and $amount
	* it returns the response text if its successfull
	*/
	function chainedPayment($data , $amount ) {
		if(defined('__ORDERS_CHAINED_PAYMENT')) {
            	App::import('Component', 'Orders.Chained');
	        	$component = new ChainedComponent();
	        	if (method_exists($component, 'initialize')) {
	            	$component->initialize($this->Controller);
		        }
		        if (method_exists($component, 'startup')) {
		            $component->startup($this->Controller);
		        }
            	$component->chainedSettings($data['Billing']);
    			$component->Pay($amount);
				if($component->response['response_code'] == 1) {
					return " Payment has been transfered to its vendors" ;
				}
		}
	}

	/* 
	 * function ManageRecurringPaymentsProfileStatus($profileId, $action) 
	 * @params 
	 * $profileId: profile id of buyer
	 * $action: to suspend , cancel, reactivate the reccuring profile
	 */
	function ManageRecurringPaymentsProfileStatus($profileId, $action){
		$paypal = new Paypal();
		$paypal->setPaySettings($this->paysettings);
		$res = $paypal->ManageRecurringPaymentsProfileStatus($profileId, $action);
		
		$this->_parsePaypalResponse($res);
	}
	
	function Pay($paymentInfo,$function = "DoDirectPayment"){
		$paypal = new Paypal();
		$this->payInfo = $paymentInfo ;
		$paypal->setPaySettings($this->paysettings);

		// if existing profile recurring id for arb, update the subscription
		if ($this->recurring && !empty($paymentInfo['Billing']['arb_profile_id']))
			$res = $paypal->UpdateRecurringPaymentsProfile($paymentInfo);
		// create a new subscription of recurring type
		elseif ($this->recurring)
			$res = $paypal->CreateRecurringPaymentsProfile($paymentInfo);
		elseif ($function=="DoDirectPayment")
			$res = $paypal->DoDirectPayment($paymentInfo);
		elseif ($function=="SetExpressCheckout")
			$res = $paypal->SetExpressCheckout($paymentInfo);
		elseif ($function=="GetExpressCheckoutDetails")
			$res = $paypal->GetExpressCheckoutDetails($paymentInfo);
		elseif ($function=="DoExpressCheckoutPayment")
			$res = $paypal->DoExpressCheckoutPayment($paymentInfo);
		else
			$res = "Function Does Not Exist!";

		$this->_parsePaypalResponse($res);
	}

/**
 * Parse the response from Paypal into a more readable array
 * makes doing validation changes easier.
 *
 */
	function _parsePaypalResponse($parsedResponse = null) {
		if($parsedResponse) {
			$parsedResponse['reason_code'] = $parsedResponse['ACK'];
			switch($parsedResponse['ACK']) {
				case 'Success' :
					$parsedResponse['reason_text'] = 'Successful Payment';
					if(defined('__ORDERS_CHAINED_PAYMENT')) {
						$parsedResponse['reason_text'] .= $this->chainedPayment($this->payInfo, $parsedResponse['AMT']) ;
					}
					$parsedResponse['response_code'] = 1;
					$parsedResponse['description'] = 'Transaction Completed';
					break;
				case 'SuccessWithWarning' :
					$parsedResponse['response_code'] = 1;
					$parsedResponse['reason_text'] = $parsedResponse['L_SHORTMESSAGE0'];
					$parsedResponse['description'] = $parsedResponse['L_LONGMESSAGE0'];
					break;
				case 'FailureWithWarning' :
				case 'Failure' :
					$parsedResponse['response_code'] = 3; // similar to authorize
					$parsedResponse['reason_text'] = $parsedResponse['L_SHORTMESSAGE0'];
					$parsedResponse['description'] = $parsedResponse['L_LONGMESSAGE0'];
					break;
			}
			if(isset($parsedResponse['AMT']))
				$parsedResponse['amount'] = $parsedResponse['AMT'];
			if(isset($parsedResponse['TRANSACTIONID']))
				$parsedResponse['transaction_id'] = $parsedResponse['TRANSACTIONID'];

			//if PROFILEID is set then it is reccuring payment and
			// it will get profile info
			if(isset($parsedResponse['PROFILEID'])) {
				$paypal = new Paypal();
				$paypal->setPaySettings($this->paysettings);

				$res = $paypal->GetRecurringPaymentsProfileDetails($parsedResponse['PROFILEID']);

				// recurrence type missing
				$parsedResponse['transaction_id'] = $res['PROFILEID'];
				$parsedResponse['description'] = $res['DESC'];
				$parsedResponse['is_arb'] = 1;
				$parsedResponse['arb_payment_start_date'] = $res['PROFILESTARTDATE'];
				$parsedResponse['arb_payment_end_date'] = $res['FINALPAYMENTDUEDATE'];
				$parsedResponse['amount'] = $res['AMT'];
				$parsedResponse['meta'] = "CORRELATIONID:{$res['CORRELATIONID']}, BUILD:{$res['BUILD']}, STATUS:{$res['STATUS']}".
					"BILLINGPERIOD:{$res['BILLINGPERIOD']}, BILLINGFREQUENCY:{$res['BILLINGFREQUENCY']}, TOTALBILLINGCYCLES:{$res['TOTALBILLINGCYCLES']}";
			}

			if(isset($parsedResponse['CVV2MATCH']) && isset($parsedResponse['CORRELATIONID']))
				$parsedResponse['meta'] = "CORRELATIONID:{$parsedResponse['CORRELATIONID']}, CVV2MATCH:{$parsedResponse['CVV2MATCH']}";
		}
		$this->response = $parsedResponse;
	}

}
?>
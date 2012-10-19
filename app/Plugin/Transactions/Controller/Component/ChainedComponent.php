<?php
App::import('Vendor','chained' ,array('file'=>'paypal/chained.php'));

class ChainedComponent extends Object{
	
	var $paysettings = array();
	var $chainedSettings =array();
	var $response = array();
	
	//initialize paypal settings and chained settings 
	function initialize(&$controller, $settings=array()) {
		if(defined('__ORDERS_PAYPAL_ADAPTIVE') && defined('__ORDERS_CHAINED_PAYMENT')) {
            $this->paysettings = unserialize(__ORDERS_PAYPAL_ADAPTIVE);
            $this->chainedSettings = unserialize(__ORDERS_CHAINED_PAYMENT);
		}
	}
	
	//used to set chained settings 
	function chainedSettings($chainedSettings = array()){
		$this->chainedSettings = array_merge($this->chainedSettings, $chainedSettings);
	}
	
	// calculate payment according to given percentage with the transaction amount 
	function payAmount($amount = null) {
		foreach($this->chainedSettings['receiverAmountArray'] as &$amt){
			$amt = ($amount/100) * $amt ;
		}
	}
	
	// pay function calls adaptive payments method to do chained payment  
	function Pay($amount = null){
		$chained = new Chained();
		$chained->setPaySettings($this->paysettings);
		$this->payAmount($amount);
		$this->chainedSettings['trackingId'] = $chained->generateTrackingID();
		$res = $chained->CallPay($this->chainedSettings);
		$this->_parsePaypalChainedResponse($res);
	}
	
	// response of the chained payment 
	function _parsePaypalChainedResponse($parsedResponse = null) {
		$ack = strtoupper($parsedResponse["responseEnvelope.ack"]);
		if($ack=="SUCCESS")
		{
			// the Pay API call was made for an existing preapproval agreement so no approval flow follows
			// payKey is the key that you can use to identify the result from this Pay call
			$payKey = urldecode($parsedResponse["payKey"]);
			// paymentExecStatus is the status of the payment
			$paymentExecStatus = urldecode($parsedResponse["paymentExecStatus"]);
			// note that in order to get the exact status of the transactions resulting from
			// a Pay API call you should make the PaymentDetails API call for the payKey
			$parsedResponse['response_code'] = 1;
		} 
		else  
		{
			//Display a user friendly Error on the page using any of the following error information returned by PayPal
			//TODO - There can be more than 1 error, so check for "error(1).errorId", then "error(2).errorId", and so on until you find no more errors.
			/*$ErrorCode = urldecode($parsedResponse["error(0).errorId"]);
			$ErrorMsg = urldecode($parsedResponse["error(0).message"]);
			$ErrorDomain = urldecode($parsedResponse["error(0).domain"]);
			$ErrorSeverity = urldecode($parsedResponse["error(0).severity"]);
			$ErrorCategory = urldecode($parsedResponse["error(0).category"]);
			echo "<pre>" . print_r($parsedResponse) . "</pre>";
			echo "Pay API call failed. </br>";
			echo "Detailed Error Message: </br>" . $ErrorMsg;
			echo "Error Code: </br>" . $ErrorCode;
			echo "Error Severity: </br>" . $ErrorSeverity;
			echo "Error Domain: </br>" . $ErrorDomain;
			echo "Error Category: </br>" . $ErrorCategory;*/
			$parsedResponse['response_code'] = 3;
		}
		$this->response = $parsedResponse;
	}
}

?>
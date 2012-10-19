<?php
require('AuthnetCIM.php');
class AuthorizeonlyComponent extends Object { 
	
	public $response = array();
	public $recurring = false;
	public $login	=  ''; // set in startup
	public $transkey = ''; // set in startup
	public $data = null;
	
/** 
 * set recurring value default is false
 */
	public function recurring($val = false) {
		$this->recurring = $val;
	}
	
	public function startup(&$controller) { 
        // This method takes a reference to the controller which is loading it. 
        // Perform controller initialization here. 
		$this->login = defined('__ORDERS_TRANSACTIONS_AUTHORIZENET_LOGIN_ID') ? __ORDERS_TRANSACTIONS_AUTHORIZENET_LOGIN_ID : null;
		$this->transkey = defined('__ORDERS_TRANSACTIONS_AUTHORIZENET_LOGIN_ID') ? __ORDERS_TRANSACTIONS_AUTHORIZENET_LOGIN_ID : null;
		
    }

/**
 * Payment by chargin CC based on Authorize.net
 *
 */
	public function Pay($data) {
		$this->request->data = $data;
		//create AuthnetCIM class object
		$this->authnetCIM = new AuthnetCIM($this->login, $this->transkey, 1);
		$this->cimCustomerProfile($this->request->data);	
	}

	public function cimPayment() {
			
		//@todo: make this refID (optional) to come from some field or store this for later use
		$this->authnetCIM->setParameter('refID', 150);
		
		$this->authnetCIM->setParameter('customerProfileId', $this->request->data['Billing']['cim_profile_id']);
		$this->authnetCIM->setParameter('customerPaymentProfileId', $this->request->data['Billing']['cim_payment_profile_id']);
		$this->authnetCIM->setParameter('amount', $this->request->data['Order']['theTotal']);
		$this->authnetCIM->setParameter('cardCode', 125);
		$this->authnetCIM->createCustomerProfileTransaction('profileTransAuthOnly');
		$this->_parseCIMResponse($this->authnetCIM);
	}
	
	public function cimPaymentProfile() {
			
		//@todo: make this refID (optional) to come from some field or store this for later use
		$this->authnetCIM->setParameter('refID', 150);
		
		$this->authnetCIM->setParameter('customerProfileId', $this->request->data['Billing']['cim_profile_id']);
		$this->authnetCIM->setParameter('billToFirstName', $this->request->data['Billing']['first_name']); 
		$this->authnetCIM->setParameter('billToLastName', $this->request->data['Billing']['last_name']); 
		$this->authnetCIM->setParameter('billToAddress', $this->request->data['Billing']['street_address_1'] . ' ' . $this->request->data['Billing']['street_address_2']);
		$this->authnetCIM->setParameter('billToCity', $this->request->data['Billing']['city']);
		$this->authnetCIM->setParameter('billToState', $this->request->data['Billing']['state']);
		
		$this->authnetCIM->setParameter('billToZip', $this->request->data['Billing']['zip']);
		$this->authnetCIM->setParameter('billToCountry', $this->request->data['Billing']['country']);
		$this->authnetCIM->setParameter('cardNumber',$this->request->data['CreditCard']['card_number']); 
		$this->authnetCIM->setParameter('expirationDate', $this->request->data['CreditCard']['expiration_year']
				."-".$this->request->data['CreditCard']['expiration_month']);
	
		$this->authnetCIM->createCustomerPaymentProfile();
		$this->_parseCIMResponse($this->authnetCIM);
	}
    
	
	public function cimCustomerProfile() {
			
		//@todo: make this refID (optional) to come from some field or store this for later use
		$this->authnetCIM->setParameter('refID', 150);
		$this->authnetCIM->setParameter('merchantCustomerId', $this->request->data['Billing']['user_id']);
		
		$this->authnetCIM->setParameter('billToFirstName', $this->request->data['Billing']['first_name']); 
		$this->authnetCIM->setParameter('billToLastName', $this->request->data['Billing']['last_name']); 
		$this->authnetCIM->setParameter('billToAddress', $this->request->data['Billing']['street_address_1'] . ' ' . $this->request->data['Billing']['street_address_2']);
		$this->authnetCIM->setParameter('billToCity', $this->request->data['Billing']['city']);
		$this->authnetCIM->setParameter('billToState', $this->request->data['Billing']['state']);
		
		$this->authnetCIM->setParameter('billToZip', $this->request->data['Billing']['zip']);
		$this->authnetCIM->setParameter('billToCountry', $this->request->data['Billing']['country']);
		$this->authnetCIM->setParameter('cardNumber',$this->request->data['CreditCard']['card_number']); 
		$this->authnetCIM->setParameter('expirationDate', $this->request->data['CreditCard']['expiration_year']
				."-".$this->request->data['CreditCard']['expiration_month']);
	
		$this->authnetCIM->setParameter('shipToFirstName', $this->request->data['Shipping']['first_name']); 
		$this->authnetCIM->setParameter('shipToLastName', $this->request->data['Shipping']['last_name']); 
		$this->authnetCIM->setParameter('shipToAddress', $this->request->data['Shipping']['street_address_1'] . ' ' . $this->request->data['Shipping']['street_address_2']);
		$this->authnetCIM->setParameter('shipToCity', $this->request->data['Shipping']['city']);
		$this->authnetCIM->setParameter('shipToState', $this->request->data['Shipping']['state']);
		$this->authnetCIM->setParameter('shipToZip', $this->request->data['Shipping']['zip']);
		$this->authnetCIM->setParameter('shipToCountry', $this->request->data['Shipping']['country']);
		
		$this->authnetCIM->createCustomerProfile();
		
		$payment_profile_id  = null;
		$profile_id = null; // customer profile id
		
		if(!$this->authnetCIM->isSuccessful() && 
					strpos($this->authnetCIM->getResponse(), 'duplicate')) {
			// if failure but duplicate entry
			$duplicate_response = explode(" ", $this->authnetCIM->getResponse());
			// customer profile id existing customer
			$profile_id = $duplicate_response[5];
		
			$this->authnetCIM->setParameter('customerProfileId', $profile_id);
			$this->authnetCIM->getCustomerProfile();
			
			$found = false;
			// if multiple payment profiles
			if(is_array($this->authnetCIM->paymentProfiles['paymentProfiles'])) {
				foreach($this->authnetCIM->paymentProfiles['paymentProfiles'] as $profile ) {
					$payment_profile_id = $profile->customerPaymentProfileId;
					$profile_card_number = $profile->payment->creditCard->cardNumber;
					if(substr($profile_card_number, -4) == substr($this->request->data['CreditCard']['card_number'], -4)){
						$found = true;
						break; // found existing profile
					}
					
				}
			} else { // else if single profile of payment
				$payment_profile_id = $this->authnetCIM->paymentProfiles['paymentProfiles']->customerPaymentProfileId;
				$found = true;
			}
			
			if (!$found) { // credit card profile found
				$payment_profile_id = null; // this is done because if no match is found we ned to create
					// a new profile below
			}
		}
		else if($this->authnetCIM->isSuccessful()) {
			// if successful
			$profile_id = $this->authnetCIM->getProfileID();
		} 

		// crate new payment profile
		if ($profile_id && !$payment_profile_id) {

			$this->authnetCIM->setParameter('customerProfileId', $profile_id);
			$this->authnetCIM->createCustomerPaymentProfile();

			if($this->authnetCIM->isSuccessful()) {
				$payment_profile_id = $this->authnetCIM->getPaymentProfileId();
			}
		}

		$this->_parseCIMResponse($this->authnetCIM , $profile_id, $payment_profile_id);
	}

/**
 * parseCIMResponse()
 * @parameters AuthnetCIM object, customer profile id, customer payment profile id   
 *
 */
	public function _parseCIMResponse($cim, $profile_id, $payment_profile_id) {
		
		//if profile id and payment profile id is set 
		if(isset($profile_id) && isset($payment_profile_id)) {
			$parsedResponse['description'] = 'Transaction'; // The transaction description, Up to 255 characters (no symbols)
			$parsedResponse['response_code'] = 1; //response code 1 for successfull response
			$parsedResponse['transaction_type'] = 'auth_only';
			$parsedResponse['reason_text'] = 'Transaction Successfull';
		} else { //if profile id is not set
			$parsedResponse['description'] = $cim->getDescription(); // The transaction description, Up to 255 characters (no symbols)
			$parsedResponse['response_code'] = $cim->getResponseCode(); //response code 1 for successfull response
			$parsedResponse['response_subcode'] = $cim->getResponseSubcode(); // A code used by the payment gateway for internal transaction tracking
			$parsedResponse['reason_code'] = $cim->getReasonCode(); // A code that provides more details about the result of the transaction
			$parsedResponse['reason_text'] = $cim->getResponseText();
			$parsedResponse['transaction_type'] = $cim->getTransactionType();
		   	$parsedResponse['meta'] = $cim->getResponse() ;
		}
		$parsedResponse['cim_profile_id'] = $profile_id;
		$parsedResponse['cim_payment_profile_id'] = $payment_profile_id;
		$parsedResponse['transaction_id'] = $profile_id; // The payment gateway assigned identification number for the transaction
		$parsedResponse['amount'] = $this->request->data['Order']['theTotal'];
	   	$this->response = $parsedResponse;
	}
	
}
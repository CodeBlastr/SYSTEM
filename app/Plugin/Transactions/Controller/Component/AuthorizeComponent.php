<?php
class AuthorizeComponent extends Object { 
	
	public $components = array('Orders.Arb');
	public $response = array();
	public $recurring = false;
	public $x_type = 'AUTH_CAPTURE';
	
	//set recurring value default is false
	public function recurring($val = false) {
		$this->recurring = $val;
	}
	
	/*
	 * authorizeonly function use to set the value of 
	 * x_type variable for the payment  
	 */
	public function authorizeonly($val = false) {
		if($val) {
			$this->x_type = 'AUTH_ONLY';	
		}
	}
	
	public function startup(&$controller) { 
        // This method takes a reference to the controller which is loading it. 
        // Perform controller initialization here. 
    }

/**
 * Payment by chargin CC based on Authorize.net
 *
 */
	public function Pay($data) {
		App::import('Component', 'Orders.Arb');
		$this->Arb = new ArbComponent();
		if($this->recurring) {
			// if existing profile recurring id for arb, update the subscription
			if(!empty($data['Billing']['arb_profile_id'])) {
			  	$this->arbPaymentUpdate($data);
			} else {
				// create a new subscription of recurring type
				$this->arbPayment($data);
			}
		} else {
     		 $this->simplePayment($data);
		}
	}
    
	/* 
	 * function ManageRecurringPaymentsProfileStatus($profileId, $action) 
	 * @params 
	 * $profileId: profile id of buyer
	 */
	public function ManageRecurringPaymentsProfileStatus($profileId, $action = 'Suspend'){
		App::import('Component', 'Orders.Arb');
		$this->Arb = new ArbComponent();
		$this->arbPaymentSuspend($profileId);
	}
    
/**
	 * payment for normal charging
	 * @param $data: user + p-ayment data 
	 * @return unknown_type
	 */
	public function simplePayment($data) {	
		// setup variables 
		$ccexp = $data['CreditCard']['expiration_month'] 
				. '/' . $data['CreditCard']['expiration_year']; 
				
		 
		$DEBUGGING					= 1;				# Display additional information to track down problems
		$TESTING		  			  = 1;				# Set the testing flag so that transactions are not live
		$ERROR_RETRIES				= 2;				# Number of transactions to post if soft errors occur
	 
		$auth_net_tran_key = defined('__ORDERS_TRANSACTIONS_AUTHORIZENET_TRANSACTION_KEY') ? 
										__ORDERS_TRANSACTIONS_AUTHORIZENET_TRANSACTION_KEY : '' ;
		$auth_net_login_id = defined('__ORDERS_TRANSACTIONS_AUTHORIZENET_LOGIN_ID') ?
										__ORDERS_TRANSACTIONS_AUTHORIZENET_LOGIN_ID : '' ;
		//echo $auth_net_tran_key ;
		### $auth_net_url				= "https://certification.authorize.net/gateway/transact.dll";
		#  Uncomment the line ABOVE for test accounts or BELOW for live merchant accounts 
		$auth_net_url				= defined('__ORDERS_TRANSACTIONS_AUTHORIZENET_MODE') ? 'https://test.authorize.net/gateway/transact.dll' : 'https://secure.authorize.net/gateway/transact.dll';
		$authnet_values	= array 
		( 
			"x_login"				=> $auth_net_login_id, 
			"x_version"				=> "3.1", 
			"x_delim_char"			=> "|", 
			"x_delim_data"			=> "TRUE", 
			"x_url"					=> "FALSE", 
			"x_type"				=> $this->x_type, 
			"x_method"				=> "CC", 
			"x_tran_key"			=> $auth_net_tran_key, 
			"x_relay_response"		=> "FALSE", 
			"x_card_num"			=> str_replace(" ", "", $data['CreditCard']['card_number']), 
			"x_card_code"			=> $data['CreditCard']['cv_code'], 
			"x_exp_date"			=> $ccexp,
			"x_description"		  	=> $data['Meta']['description'], 
			"x_amount"				=> $data['Order']['theTotal'], 
			"x_tax"				  	=> $data['Meta']['tax'], 
			"x_freight"			  	=> $data['Meta']['shipping'], 
			"x_first_name"			=> $data['Billing']['first_name'], 
			"x_last_name"			=> $data['Billing']['last_name'], 
			"x_address"				=> $data['Billing']['street_address_1'] . $data['Billing']['street_address_2'], 
			"x_city"				=> $data['Billing']['city'], 
			"x_state"				=> $data['Billing']['state'], 
			"x_zip"				  	=> $data['Billing']['zip'], 
			"x_country"			  	=> $data['Billing']['country'], 
			"x_email"				=> isset($data['Meta']['email']) ? $data['Meta']['email'] : '', 
			"x_phone"				=> isset($data['Meta']['phone']) ? $data['Meta']['phone'] : '',
			"x_ship_to_first_name"	=> $data['Shipping']['first_name'], 
			"x_ship_to_last_name"	=> $data['Shipping']['last_name'], 
			"x_ship_to_address"	  	=> $data['Shipping']['street_address_1'] . $data['Shipping']['street_address_2'], 
			"x_ship_to_city"		=> $data['Shipping']["city"], 
			"x_ship_to_state"		=> $data['Shipping']["state"], 
			"x_ship_to_zip"		  	=> $data['Shipping']["zip"], 
			"x_ship_to_country"	  	=> $data['Shipping']["country"], 
		); 
		 
		$fields = ""; 
		foreach ( $authnet_values as $key => $value ) $fields .= "$key=" . urlencode( $value ) . "&";
		// Post the transaction (see the code for specific information) 
		$ch = curl_init($auth_net_url);	
		curl_setopt($ch, CURLOPT_URL, $auth_net_url);
		curl_setopt($ch, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
		curl_setopt($ch, CURLOPT_POSTFIELDS, rtrim( $fields, "& " )); // use HTTP POST to send form data
		 
		### Go Daddy Specific CURL Options 
		#curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, true);  
		#curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);  
		#curl_setopt($ch, CURLOPT_PROXY, 'http://proxy.shr.secureserver.net:3128');  
		#curl_setopt($ch, CURLOPT_TIMEOUT, 120); 
		### End Go Daddy Specific CURL Options 
			
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // uncomment this line if you get no gateway response. ###
		$resp = curl_exec($ch); //execute post and get results 
		curl_close ($ch); 
		 
		// Parse through response string 
		$text = $resp; 
		$h = substr_count($text, "|"); 
		$h++; 
		$responsearray = array(); 

		for($j=1; $j <= $h; $j++){ 
			$p = strpos($text, "|"); 
			if ($p === false) { // note: three equal signs x_delim_char is obviously not found in the last go-around 
				$responsearray[$j] = $text;				// This is final response string 
			} 
			else { 
				$p++; 
				//  get one portion of the response at a time 
				$pstr = substr($text, 0, $p); 

				//  this prepares the text and returns one value of the submitted 
				//  and processed name/value pairs at a time 
				//  for AIM-specific interpretations of the responses 
				//  please consult the AIM Guide and look up 
				//  the section called Gateway Response API 
				$pstr_trimmed = substr($pstr, 0, -1); // removes "|" at the end 
				if($pstr_trimmed==""){ 
					$pstr_trimmed=""; 
				} 

				$responsearray[$j] = $pstr_trimmed; 
				// remove the part that we identified and work with the rest of the string
				$text = substr($text, $p); 
			} // end if $p === false 
		} // end parsing for loop 
		$this->_parseAuthorizeResponse($responsearray);
	}
	 // end authorizePayment function 

	
/**
 * Parse the response from Authorize.net into a more readable array
 * makes doing validation changes easier.
 *
 * @todo		There are more codes we could add. List is here : http://developer.authorize.net/guides/AIM/
 */
	protected function _parseAuthorizeResponse($response) {
		$parsedResponse['response_code'] = $response[1]; // 1 = approved, 2 = declined, 3 = error, 4 = held for review
		$parsedResponse['response_subcode'] = $response[2]; // A code used by the payment gateway for internal transaction tracking
		$parsedResponse['reason_code'] = $response[3]; // A code that provides more details about the result of the transaction
		$parsedResponse['reason_text'] = $response[4]; // A brief description of the result, which corresponds with the response reason code
		$parsedResponse['authorization_code'] = $response[5]; // 6 character authorization or approval code
		$parsedResponse['avs_response'] = $response[6];
		/*A = Address (Street) matches, ZIP does not
		B = Address information not provided for AVS check
		E = AVS error
		G = Non-U.S. Card Issuing Bank
		N = No Match on Address (Street) or ZIP
		P = AVS not applicable for this transaction
		R = Retry � System unavailable or timed out
		S = Service not supported by issuer
		U = Address information is unavailable
		W = Nine digit ZIP matches, Address (Street) does not
		X = Address (Street) and nine digit ZIP match
		Y = Address (Street) and five digit ZIP match
		Z = Five digit ZIP matches, Address (Street) does not*/
		$parsedResponse['transaction_id'] = $response[7]; // The payment gateway assigned identification number for the transaction
		$parsedResponse['invoice_number'] = $response[8]; //	The merchant-assigned invoice number for the transaction. Up to 20 characters (no symbols)
		$parsedResponse['description'] = $response[9]; // The transaction description, Up to 255 characters (no symbols)
		$parsedResponse['amount'] = $response[10]; // The amount of the transaction, Up to 15 digits
		$parsedResponse['method'] = $response[11]; // The payment method, CC or ECHECK
		$parsedResponse['transaction_type'] = $response[12]; // The type of credit card transaction, AUTH_CAPTURE, AUTH_ONLY, CAPTURE_ONLY, CREDIT, PRIOR_AUTH_CAPTURE, VOID
		$parsedResponse['md5_hash'] = $response[38]; // The payment gateway generated MD5 hash value that can be used to authenticate the transaction response.
		$parsedResponse['ccv_match_code'] = $response[39]; //The card code verification (CCV) response code
		/*M = Match
		N = No Match
		P = Not Processed
		S = Should have been present
		U = Issuer unable to process request*/
		$parsedResponse['hiddden_card_number'] = $response[51]; // card number in XXXX1111 format
		$parsedResponse['card_type_name'] = $response[52]; // CC type
		//pr($parsedResponse);
		$this->response = $parsedResponse;
	}
	
	public function arbPayment($data) {

		$login	=  defined('__ORDERS_TRANSACTIONS_AUTHORIZENET_LOGIN_ID') ?
										__ORDERS_TRANSACTIONS_AUTHORIZENET_LOGIN_ID : '' ; 
		$transkey = defined('__ORDERS_TRANSACTIONS_AUTHORIZENET_TRANSACTION_KEY') ? 
										__ORDERS_TRANSACTIONS_AUTHORIZENET_TRANSACTION_KEY : '' ;
		
		# for test API hardcoded TRUE.
		$this->Arb->AuthnetARB($login,$transkey);

		$this->Arb->setParameter('interval_length', $data['Billing']['interval_length']);
		$this->Arb->setParameter('interval_unit', 'months'); 
		$this->Arb->setParameter('startDate', date('Y-m-d', mktime(date('H'), date('i'), date('s'), date("m"), date("d")+1, date("Y")))); 
		$this->Arb->setParameter('totalOccurrences', $data['Billing']['totalOccurrences']); 
		$this->Arb->setParameter('trialOccurrences', $data['Billing']['trialOccurrences']); 
		$this->Arb->setParameter('trialAmount', $data['Billing']['trialAmount']);
		$this->Arb->setParameter('amount', $data['Order']['theTotal']);
		
		# @todo: make this refID (optional) to come from some field or store this for later use 
		$this->Arb->setParameter('refID', 150); 
		
		# $this->Arb->setParameter('subscriptionId', $data['Order']['subscription_id']);
		$this->Arb->setParameter('cardNumber',$data['CreditCard']['card_number']); 
		# $this->Arb->setParameter('expirationDate', $data['CreditCard']['expiration_year']
		#		."-".$data['CreditCard']['expiration_month']);
		$this->Arb->setParameter('expirationDate', '2016-05');
	
		$this->Arb->setParameter('firstName', $data['Member']['first_name']); 
		$this->Arb->setParameter('lastName', $data['Member']['last_name']); 
		$this->Arb->setParameter('address', $data['Member']['billing_address']);
		$this->Arb->setParameter('city', $data['Member']['billing_city']);
		$this->Arb->setParameter('state', $data['Member']['billing_state']);
		
		$this->Arb->setParameter('zip', $data['Member']['billing_zip']);
		$this->Arb->setParameter('country', $data['Member']['billing_country']);
	
		$this->Arb->setParameter('subscrName', $data['Member']['first_name']); 
		# $this->Arb->deleteAccount();exit;
		$this->Arb->createAccount();
		$this->_parseARBResponse($this->Arb);
	}

	public function arbPaymentUpdate($data) {
		$login	=  defined('__ORDERS_TRANSACTIONS_AUTHORIZENET_LOGIN_ID') ?
											__ORDERS_TRANSACTIONS_AUTHORIZENET_LOGIN_ID : '' ; 
		$transkey = defined('__ORDERS_TRANSACTIONS_AUTHORIZENET_TRANSACTION_KEY') ? 
											__ORDERS_TRANSACTIONS_AUTHORIZENET_TRANSACTION_KEY : '' ;
		
		# for test API hardcoded TRUE.
		$this->Arb->AuthnetARB($login,$transkey, TRUE);
	
		$this->Arb->setParameter('amount', $data['Order']['theTotal']);
		#@todo: make this refID (optional) to come from some field or store this for later use 
		$this->Arb->setParameter('refID', 150); 
		$this->Arb->setParameter('subscriptionId', $data['Billing']['arb_profile_id']);
		$this->Arb->updateAccount();
		$this->_parseARBResponse($this->Arb);
	}
	

	public function arbPaymentSuspend($profileId) {
		$login	=  defined('__ORDERS_TRANSACTIONS_AUTHORIZENET_LOGIN_ID') ?
										__ORDERS_TRANSACTIONS_AUTHORIZENET_LOGIN_ID : '' ; 
		$transkey = defined('__ORDERS_TRANSACTIONS_AUTHORIZENET_TRANSACTION_KEY') ? 
										__ORDERS_TRANSACTIONS_AUTHORIZENET_TRANSACTION_KEY : '' ;
		
		# for test API hardcoded TRUE.
		$this->Arb->AuthnetARB($login,$transkey, TRUE);

		# @todo: make this refID (optional) to come from some field or store this for later use 
		$this->Arb->setParameter('refID', 150); 
		$this->Arb->setParameter('subscriptionId', $profileId);
		$this->Arb->deleteAccount();
		$this->_parseARBResponse($this->Arb);
	}

/**
 * ParseARB() 
 *
 */
	protected function _parseARBResponse($arb) {
				
		if ($this->Arb->isSuccessful()) { 
			$parsedResponse['response_code'] = 1;
			$parsedResponse['is_arb'] = 1;
			$parsedResponse['reason_code'] = $this->Arb->getSubscriberID();
			$parsedResponse['description'] = 'Transaction Completed';
	   	}
	   	else { $parsedResponse['response_code'] = 3; 
		   	$parsedResponse['description'] = 'Transaction Failed';
	   	}
	   	$parsedResponse['response_subcode'] = $this->Arb->getResultCode();
	   	$parsedResponse['reason_text'] = $this->Arb->getResponse();
	   	if(isset($this->Arb->params['startDate'])) {
	   		$parsedResponse['arb_payment_start_date'] = $this->Arb->params['startDate'];	
	   	}
		//$parsedResponse['arb_payment_end_date'] = $res['FINALPAYMENTDUEDATE'];
	   	if(isset($this->Arb->params['amount'])){
			$parsedResponse['amount'] = $this->Arb->params['amount'];	   		
	   	}
	   	$parsedResponse['transaction_id'] = $this->Arb->getSubscriberID();
	   	$parsedResponse['meta'] = $this->Arb->getRawResponse() ;
		$this->response = $parsedResponse;
		
	}
	
}
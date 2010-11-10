<?php  
/**
 * Authoriz.net Checkout Component
 *
 * All transactions should be pushed through this controller. It is the catch all 
 * and should be able to (though it doesn't as of today) handle all monetary transaction
 * types.  
 *
 * PHP versions 5
 *
 * Zuha(tm) : Business Management Applications (http://zuha.com)
 * Copyright 2009-2010, Zuha Foundation Inc. (http://zuhafoundation.org)
 *
 * Licensed under GPL v3 License
 * Must retain the above copyright notice and release modifications publicly.
 *
 * @copyright     Copyright 2009-2010, Zuha Foundation Inc. (http://zuha.com)
 * @link          http://zuha.com Zuha™ Project
 * @package       zuha
 * @subpackage    zuha.app.controllers
 * @since         Zuha(tm) v 0.0.1
 * @license       GPL v3 License (http://www.gnu.org/licenses/gpl.html) and Future Versions
 * @todo		  Make this give the response success or failure instead of having to handle it in the controller.  
 * @todo		  Think about moving this to the /plugins/transactions/libs - seems like a more proper place for it.
 */
class AuthorizeNetComponent extends Object { 

    ### Created By Graydon Stoner - www.getstonered.com ### 

    //////////// Controller Usage \\\\\\\\\\\\\ 
    /* 
    $components = array('AuthorizeNet'); 
     
    $billinginfo = array("fname" => "First", 
                            "lname" => "Last", 
                            "address" => "123 Fake St. Suite 0", 
                            "city" => "City", 
                            "state" => "ST", 
                            "zip" => "90210", 
                            "country" => "USA"); 
     
    $shippinginfo = array("fname" => "First", 
                            "lname" => "Last", 
                            "address" => "123 Fake St. Suite 0", 
                            "city" => "City", 
                            "state" => "ST", 
                            "zip" => "90210", 
                            "country" => "USA"); 
     
    $response = $this->AuthorizeNet->chargeCard('########', '##############', '4111111111111111', '01', '2010', '123', true, 110, 5, 5, "Purchase of Goods", $billinginfo, "email@email.com", "555-555-5555", $shippinginfo); 
    $response:Array = $this->AuthorizeNet->chargeCard($loginid:String, $trankey:String, $ccnum:String, $ccexpmonth:String, $ccexpyear:String, $ccver:String, $live:Boolean, $amount:Number, $tax:Number, $shipping:Number, $desc:String, $billinginfo:Array, $email:String, $phone:String, $shippinginfo:Array);
     
    ////////// USAGE NOTES \\\\\\\\\\\\ 
     
    PARAMETERS 
    $loginid         : Your Authorize.net Login ID 
    $trankey         : Your Authorize.net Transaction Key 
    $ccnum             : The system removes any spaces in the string to meet Authorize.net requirements
    $ccexpmonth     : 2 digit month string 
    $ccexpyear         : 2 or 4 digit year string 
    $ccver             : The 3 or 4 digit card verificaton code found on the back of Visa/Mastercard and the front of AmEx
    $live             : Whether to process as a live or test transaction - true : Live Transcation - false : Test Transaction
    $amount            : Total amount of the transaction. This must include both tax and shipping if applicable.
    $tax            : Tax amount charged (if any) 
    $shipping        : Shipping cost (if any) 
    $desc            : Description of the transaction to be logged into Authorize.net system
    $billinginfo    : Associative Array containing values for customer billing details 
    $email            : Customer email 
    $phone            : Customer phone 
    $billinginfo    : Associative Array containing values for customer shipping details 
     
    RESPONSE 
    $response : Array (1 based) containing the Payment Gateway Resonse fields  
     
    // Important Response Values 
    $response[1] = Response Code (1 = Approved, 2 = Declined, 3 = Error, 4 = Held for Review)
    $response[2] = Response Subcode (Code used for Internal Transaction Details) 
    $response[3] = Response Reason Code (Code detailing response code) 
    $response[4] = Response Reason Text (Text detailing response code and response reason code)
    $response[5] = Authorization Code (Authorization or approval code - 6 characters) 
    $response[6] = AVS Response (Address Verification Service response code - A, B, E, G, N, P, R, S, U, W, X, Y, Z)
                    (A, P, W, X, Y, Z are default AVS confirmation settings - Use your Authorize.net Merchant Interface to change these settings)
                    (B, E, G, N, R, S, U are default AVS rejection settings - Use your Authorize.net Merchant Interface to change these settings)
    $response[7] = Transaction ID (Gateway assigned id number for the transaction) 
    $response[38] = MD5 Hash (Gateway generated MD5 has used to authenticate transaction response)
    $response[39] = Card Code Response (CCV Card Code Verification response code - M = Match, N = No Match, P = No Processed, S = Should have been present, U = Issuer unable to process request)
     
    For more information about the Authorize.net AIM response consult their 
    AIM Implementation Guide at http://developer.authorize.net/guides/AIM/ and 
    go to Section Four : Fields in the Payment Gateway Response for more details. 
     
    NOTES 
    This component is meant to abstract payment processing on a website.  
    As varying sites require different requirements for information, security, 
    or card processing (like changing Address Verification requirement) the 
    component does not try to provide any logic to determine if a transaction 
    was successful. It is up to the user implementing this code to process the 
    response array and provide response accordingly. 
     
    */ 


    // class variables go here 

    function startup(&$controller) { 
        // This method takes a reference to the controller which is loading it. 
        // Perform controller initialization here. 
    } 
     
    function chargeCard($loginid, $trankey, $ccnum, $ccexpmonth, $ccexpyear, $ccver, $live, $amount, $tax, $shipping, $desc, $billinginfo, $email, $phone, $shippinginfo) {
     
        // setup variables 
        $ccexp = $ccexpmonth . '/' . $ccexpyear; 
         
        $DEBUGGING                    = 1;                # Display additional information to track down problems
        $TESTING                    = 1;                # Set the testing flag so that transactions are not live
        $ERROR_RETRIES                = 2;                # Number of transactions to post if soft errors occur
     
        $auth_net_login_id            = $loginid; 
        $auth_net_tran_key            = $trankey; 
        ### $auth_net_url                = "https://certification.authorize.net/gateway/transact.dll";
        #  Uncomment the line ABOVE for test accounts or BELOW for live merchant accounts 
        $auth_net_url                = "https://secure.authorize.net/gateway/transact.dll";
         
        $authnet_values                = array 
        ( 
            "x_login"                => $auth_net_login_id, 
            "x_version"              => "3.1", 
            "x_delim_char"           => "|", 
            "x_delim_data"           => "TRUE", 
            "x_url"        	         => "FALSE", 
            "x_type"                 => "AUTH_CAPTURE", 
            "x_method"               => "CC", 
            "x_tran_key"             => $auth_net_tran_key, 
            "x_relay_response"       => "FALSE", 
            "x_card_num"             => str_replace(" ", "", $ccnum), 
            "x_card_code"            => $ccver, 
            "x_exp_date"             => $ccexp, 
            "x_description"          => $desc, 
            "x_amount"               => $amount, 
            "x_tax"                  => $tax, 
            "x_freight"              => $shipping, 
            "x_first_name"           => $billinginfo["fname"], 
            "x_last_name"            => $billinginfo["lname"], 
            "x_address"              => $billinginfo["address"], 
            "x_city"               	 => $billinginfo["city"], 
            "x_state"                => $billinginfo["state"], 
            "x_zip"                  => $billinginfo["zip"], 
            "x_country"              => $billinginfo["country"], 
            "x_email"                => $email, 
            "x_phone"                => $phone, 
            "x_ship_to_first_name"   => $shippinginfo["fname"], 
            "x_ship_to_last_name"    => $shippinginfo["lname"], 
            "x_ship_to_address"      => $shippinginfo["address"], 
            "x_ship_to_city"         => $shippinginfo["city"], 
            "x_ship_to_state"        => $shippinginfo["state"], 
            "x_ship_to_zip"          => $shippinginfo["zip"], 
            "x_ship_to_country"      => $shippinginfo["country"], 
        ); 
         
        $fields = ""; 
        foreach ( $authnet_values as $key => $value ) $fields .= "$key=" . urlencode( $value ) . "&";
         
        /////////////////////////////////////////////////////////// 
         
        // Post the transaction (see the code for specific information) 
         
         
        ### $ch = curl_init("https://certification.authorize.net/gateway/transact.dll"); 
        ###  Uncomment the line ABOVE for test accounts or BELOW for live merchant accounts
        $ch = curl_init("https://secure.authorize.net/gateway/transact.dll");   
        ### curl_setopt($ch, CURLOPT_URL, "https://secure.authorize.net/gateway/transact.dll");
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

            if ($p === false) { // note: three equal signs 
                //  x_delim_char is obviously not found in the last go-around 
                // This is final response string 
                $responsearray[$j] = $text; 
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
        $response = $this->_responseArray($responsearray);
        return $response; 
         
    } // end chargeCard function 
	

/**
 * Parse the response from Authorize.net into a more readable array
 * makes doing validation changes easier.
 *
 * @todo		There are more codes we could add. List is here : http://developer.authorize.net/guides/AIM/
 */
	function _responseArray($response) {
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
		R = Retry — System unavailable or timed out
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
		
		return $parsedResponse;
			
	}
}
?>
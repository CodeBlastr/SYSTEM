<?php

/**
 * @author <joel@razorit.com>
 */
class SagepayComponent extends Object {

  public
          $components = array('Orders.Arb'),
          $response = array(),
          $recurring = false,
          $x_type = 'PAYMENT',
          $acsurl = '', // used to store data for 3D Secure
          $pareq = '', // used to store data for 3D Secure
          $md = '', // used to store data for 3D Secure
          $status = '', // status returned from the cURL request
          $error = '';
  private
          $env = 'SIMULATOR',
          $url = '';

  //set recurring value default is false
  public function recurring($val = false) {
    $this->recurring = $val;
  }

  /**
   * authorizeonly function use to set the value of x_type variable for the payment
   * @param type $val
   */
  public function authorizeonly($val = false) {
    if ($val) {
      $this->x_type = 'AUTHENTICATE';
    }
  }

  public function startup(&$controller) {
    // This method takes a reference to the controller which is loading it.
    // Perform controller initialization here.
  }

  /**
   * Initiate Payment
   *
   */
  public function Pay($data) {

    /**
     *  config DEV / LIVE
     */
    $sagePayMode = defined('__ORDERS_TRANSACTIONS_SAGEPAY_MODE') ? __ORDERS_TRANSACTIONS_SAGEPAY_MODE : 'SIMULATOR';
    $this->env = $sagePayMode;
    $this->setUrls();

    /**
     *  Run the appropriate payment method
     */
    App::import('Component', 'Orders.Arb');
    $this->Arb = new ArbComponent();
    if ($this->recurring) {
      // if existing profile recurring id for arb, update the subscription
      if (!empty($data['Billing']['arb_profile_id'])) {
        $this->arbPaymentUpdate($data);
      } else {
        // create a new subscription of recurring type
        $this->arbPayment($data);
      }
    } else {
      $this->simplePayment($data);
    }
  }

	protected function formatRawData($data) {
	    $formatted['VPSProtocol'] = '2.23';
	    $formatted['TxType'] = $this->x_type;
	    $formatted['Vendor'] = defined('__ORDERS_TRANSACTIONS_SAGEPAY_VENDOR') ? __ORDERS_TRANSACTIONS_SAGEPAY_VENDOR : 'razorit';

    	$formatted['VendorTxCode'] = 'sage_' . time() . rand(0, 9999); /** @todo ideally an internal transaction code */

	    $formatted['Description'] = $data['Meta']['description'];
	
	    $formatted['CardHolder'] = $data['Billing']['first_name'] . ' ' . $data['Billing']['last_name'];

	    $formatted['CardNumber'] = str_replace(" ", "", $data['CreditCard']['card_number']);
	    $formatted['StartDateMonth'] = $data['CreditCard']['start_month'];
	    $formatted['StartDateYear'] = $data['CreditCard']['start_year'];
	    $creditMM = str_pad($data['CreditCard']['expiration_month'], 2, "0", STR_PAD_LEFT);
	    $creditYY = substr($data['CreditCard']['expiration_year'], 2, 2);
	    $formatted['ExpiryDate'] = $creditMM . $creditYY;
	
		App::uses('Validation', 'Utility');
	    if(Validation::cc($formatted['CardNumber'], 'visa')) {
			$cardType = 'VISA';
	    } elseif ( Validation::cc($formatted['CardNumber'], 'amex') ) {
    		$cardType = 'AMEX';
		} elseif ( Validation::cc($formatted['CardNumber'], 'mc') ) {
			$cardType = 'MC';
	    } elseif ( Validation::cc($formatted['CardNumber'], 'diners') ) {
			$cardType = 'DINERS';
		} elseif ( Validation::cc($formatted['CardNumber'], 'jcb') ) {
			$cardType = 'JCB';
		} elseif ( Validation::cc($formatted['CardNumber'], 'maestro') ) {
			$cardType = 'MAESTRO';
		}

    	$formatted['CardType'] = $cardType;/** VISA / MC / DELTA / MAESTRO / AMEX / UKE / JCB / DINERS / LASER */
	    $formatted['IssueNumber'] = $data['CreditCard']['IssueNumber'];/** @todo (Older Switch cards only. 1 or 2 digits as printed on the card) */
	    $formatted['CV2'] = $data['CreditCard']['cv_code'];

	    $formatted['BillingFirstnames'] = $data['Billing']['first_name'];
	    $formatted['BillingSurname'] = $data['Billing']['last_name'];
	    $formatted['BillingAddress1'] = $data['Billing']['street_address_1'];
	    $formatted['BillingAddress2'] = $data['Billing']['street_address_2'];
	    $formatted['BillingCity'] = $data['Billing']['city'];
	    $formatted['BillingCountry'] = $data['Billing']['country'];
	    $formatted['BillingPostCode'] = $data['Billing']['zip'];
	    $formatted['BillingPhone'] = '';

	    $formatted['DeliveryFirstnames'] = !empty($data['Shipping']['first_name']) ? $data['Shipping']['first_name'] : $formatted['BillingFirstnames'];
	    $formatted['DeliverySurname'] = !empty($data['Shipping']['last_name']) ? $data['Shipping']['last_name'] : $formatted['BillingSurname'];
	    $formatted['DeliveryAddress1'] = !empty($data['Shipping']['street_address_1']) ? $data['Shipping']['street_address_1'] : $formatted['BillingAddress1'];
	    $formatted['DeliveryAddress2'] = !empty($data['Shipping']['street_address_2']) ? $data['Shipping']['street_address_2'] : $formatted['BillingAddress2'];
	    $formatted['DeliveryCity'] = !empty($data['Shipping']['city']) ? $data['Shipping']['city'] : $formatted['BillingCity'];
	    $formatted['DeliveryCountry'] = !empty($data['Shipping']['country']) ? $data['Shipping']['country'] : $formatted['BillingCountry'];
	    $formatted['DeliveryPostCode'] = !empty($data['Shipping']['zip']) ? $data['Shipping']['zip'] : $formatted['BillingPostCode'];
	    $formatted['DeliveryPhone'] =  '';

	    $formatted['Amount'] = $data['Order']['theTotal'];
	    $formatted['Currency'] = defined('__ORDERS_TRANSACTIONS_SAGEPAY_CURRENCY') ? __ORDERS_TRANSACTIONS_SAGEPAY_CURRENCY : 'usd';


    	return $formatted;
	}

  /**
   * formatData method
   * Takes $this->data and converts it to
   * a url encoded query string
   * @return void
   * */
  private function encodeData($data) {

    $arr = array();

    $formattedData = $this->formatRawData($data);

    // loop through $this->data
    foreach ($formattedData as $key => $value) {
      // assign as an item of $arr (field=value)
      $arr[] = $key . '=' . urlencode($value);
    }

    // Implode the array using & as the glue and store the data
    return implode('&', $arr);
  }

  /**
   *  Charge the card, return the response
   * @param type $data
   */
  public function simplePayment($data) {

    $curlString = $this->encodeData($data);

    // Max exec time of 1 minute.
    set_time_limit(60);

    // Open cURL request
    $curlSession = curl_init();

    // Set the url to post request to
    curl_setopt($curlSession, CURLOPT_URL, $this->url);
    // cURL params
    curl_setopt($curlSession, CURLOPT_HEADER, 0);
    curl_setopt($curlSession, CURLOPT_POST, 1);
    // Pass it the query string we created from $this->data earlier
    curl_setopt($curlSession, CURLOPT_POSTFIELDS, $curlString);
    // Return the result instead of print
    curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, 1);
    // Set a cURL timeout of 30 seconds
    curl_setopt($curlSession, CURLOPT_TIMEOUT, 30);
    curl_setopt($curlSession, CURLOPT_SSL_VERIFYPEER, FALSE);


    // Send the request and convert the return value to an array
    $response = preg_split('/$\R?^/m', curl_exec($curlSession));

    // Check that it actually reached the SagePay server
    // If it didn't, set the status as FAIL and the error as the cURL error
    if (curl_error($curlSession)) {
      $this->status = 'FAIL';
      $this->error = curl_error($curlSession);
    }

    // Close the cURL session
    curl_close($curlSession);

    // Turn the reponse into an associative array
    for ($i = 0; $i < count($response); $i++) {
      // Find position of first "=" character
      $splitAt = strpos($response[$i], "=");
      // Create an associative array
      $this->response[trim(substr($response[$i], 0, $splitAt))] = trim(substr($response[$i], ($splitAt + 1)));
    }

    // Return values. Assign stuff based on the return 'Status' value from SagePay
    switch ($this->response['Status']) {
      case 'OK':
        // Transaction made successfully
        $responseCode = 1;
        $this->status = 'success';
        CakeSession::write('transaction.VPSTxId', $this->response['VPSTxId']); // assign the VPSTxId to a session variable for storing if need be
        CakeSession::write('transaction.TxAuthNo', $this->response['TxAuthNo']); // assign the TxAuthNo to a session variable for storing if need be
        break;
      case '3DAUTH':
        // Transaction required 3D Secure authentication
        // The request will return two parameters that need to be passed with the 3D Secure
        $this->acsurl = $this->response['ACSURL']; // the url to request for 3D Secure
        $this->pareq = $this->response['PAReq']; // param to pass to 3D Secure
        $this->md = $this->response['MD']; // param to pass to 3D Secure
        $this->status = '3dAuth'; // set $this->status to '3dAuth' so your controller knows how to handle it
        break;
      case 'REJECTED':
        // errors for if the card is declined
        $responseCode = 2;
        $this->status = 'declined';
        $this->error = 'Your payment was not authorised by your bank or your card details where incorrect.';
        break;
      case 'NOTAUTHED':
        // errors for if their card doesn't authenticate
        $responseCode = 3;
        $this->status = 'notauthed';
        $this->error = 'Your payment was not authorised by your bank or your card details where incorrect.';
        break;
      case 'INVALID':
        // errors for if the user provides incorrect card data
        $responseCode = 3;
        $this->status = 'invalid';
        $this->error = 'One or more of your card details where invalid. Please try again.';
        break;
      case 'FAIL':
        // errors for if the transaction fails for any reason
        $responseCode = 3;
        $this->status = 'fail';
        $this->error = 'An unexpected error has occurred. Please try again.';
        break;
      default:
        // default error if none of the above conditions are met
        $responseCode = 3;
        $this->status = 'error';
        $this->error = 'An error has occurred. Please try again.';
        break;
    }

    $parsedResponse = array(
        'response_code' => $responseCode,
        'reason_text' => $this->error,
        'description' => $this->response['StatusDetail']
    );

    $this->response = $parsedResponse;
  }

  /**
   * setUrls method
   * Selects which SagePay url to use (live or test)
   * based on the $this->env property
   * @return void
   * */
  private function setUrls() {
    #$this->url = ($this->env == 'DEVELOPMENT') ? 'https://test.sagepay.com/gateway/service/vspdirect-register.vsp' : 'https://live.sagepay.com/gateway/service/vspdirect-register.vsp';
    #$this->url = ($this->env == 'DEVELOPMENT') ? 'https://test.sagepay.com/Simulator/VSPDirectGateway.asp' : 'https://live.sagepay.com/gateway/service/vspdirect-register.vsp';

    switch($this->env) {
      case('LIVE') :
        $this->url = 'https://live.sagepay.com/gateway/service/vspdirect-register.vsp';
        break;
      case('DEVELOPMENT') :
        $this->url = 'https://test.sagepay.com/gateway/service/vspdirect-register.vsp';
        break;
      case('SIMULATOR') :
      default:
        $this->url = 'https://test.sagepay.com/Simulator/VSPDirectGateway.asp';
        break;
    }
  }

}
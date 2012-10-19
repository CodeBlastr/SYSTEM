<?php

/**
 * @author <joel@razorit.com>
 * @link http://www.sagepayments.net
 */
class SagepaymentComponent extends Object {

  public
          $components = array('Orders.Arb'),
          $response = '',
          $recurring = false,
          $x_type = '01', // 01 => Sale, 02 => AuthOnly, 03 => Force/PriorAuthSale, 04 => Void, 06 => Credit, 11=>PriorAuthSale by Reference (requires T_reference)
          $status = '', // status returned from the cURL request
          $error = ''; // error returned from the cURL request


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


  /**
   *  This function merely maps the data.  It will be urlencode'd later.
   * @param type $data
   * @return type
   */
	protected function formatRawData($data) {

        // preliminary formatting
          $creditMM = str_pad($data['CreditCard']['expiration_month'], 2, "0", STR_PAD_LEFT);
          $creditYY = substr($data['CreditCard']['expiration_year'], 2, 2);
          $shippingFullName = !empty($data['Shipping']['first_name']) ? $data['Shipping']['first_name'] : $data['Billing']['first_name'];
          $shippingFullName .= !empty($data['Shipping']['last_name']) ? $data['Shipping']['last_name'] : $data['Billing']['last_name'];
          $shippingAddress = !empty($data['Shipping']['street_address_1']) ? $data['Shipping']['street_address_1'] : $data['Billing']['street_address_1'];
          $shippingAddress .= !empty($data['Shipping']['street_address_2']) ? $data['Shipping']['street_address_2'] : $data['Billing']['street_address_2'];


        // merchant account settings
	    $formatted['m_id'] = defined('__ORDERS_TRANSACTIONS_SAGEPAYMENTS_MERCHANT_ID') ? __ORDERS_TRANSACTIONS_SAGEPAYMENTS_MERCHANT_ID : '';
	    $formatted['m_key'] = defined('__ORDERS_TRANSACTIONS_SAGEPAYMENTS_MERCHANT_KEY') ? __ORDERS_TRANSACTIONS_SAGEPAYMENTS_MERCHANT_KEY : '';

        // customer data
	    $formatted['C_name'] = $data['Billing']['first_name'] . ' ' . $data['Billing']['last_name'];
	    $formatted['C_address'] = trim($data['Billing']['street_address_1'] . ' ' . $data['Billing']['street_address_2']);
	    $formatted['C_city'] = $data['Billing']['city'];
	    $formatted['C_state'] = $data['Billing']['state'];
	    $formatted['C_zip'] = $data['Billing']['zip'];
	    $formatted['C_country'] = $data['Billing']['country']; // optional
	    $formatted['C_email'] = $data['Member']['email_address'];
        $formatted['C_cardnumber'] = str_replace(" ", "", $data['CreditCard']['card_number']);
	    $formatted['C_exp'] = $creditMM . $creditYY;
        $formatted['C_cvv'] = $data['CreditCard']['cv_code']; // optional. CVV
	    $formatted['C_telephone'] = ''; // optional.
	    $formatted['C_fax'] = ''; // optional.

        // shipping data
        $formatted['C_ship_name'] = $shippingFullName; // optional.
        $formatted['C_ship_address'] = $shippingAddress; // optional.
        $formatted['C_ship_city'] = !empty($data['Shipping']['city']) ? $data['Shipping']['city'] : $data['Billing']['city']; // optional.
        $formatted['C_ship_state'] = !empty($data['Shipping']['state']) ? $data['Shipping']['state'] : $data['Billing']['state']; // optional.
        $formatted['C_ship_zip'] = !empty($data['Shipping']['zip']) ? $data['Shipping']['zip'] : $data['Billing']['zip']; // optional.
        $formatted['C_ship_country'] = !empty($data['Shipping']['country']) ? $data['Shipping']['country'] :  $data['Billing']['country']; // optional.

        // transaction data
	    $formatted['T_amt'] = $data['Order']['theTotal'];
	    $formatted['T_code'] = $this->x_type; // transaction processing code
        $formatted['T_ordernum'] = time() . rand(0, 9999); // optional. unique 1-20 digit order number

        // advanced transaction data
        $formatted['T_auth'] = ''; // optional. Previous (VOICE) Authorization Code, Required for Force Transactions
        $formatted['T_reference'] = ''; // optional. Unique Reference, Required for Void and Prior Auth Transactions
        $formatted['T_trackdata'] = ''; // optional. Track 2 Data for POS Applications
        $formatted['T_customer_number'] = ''; // optional. Customer Number for Purchase Card Level II Transactions
        $formatted['T_tax'] = ''; // optional. Tax Amount (######0.00)
        $formatted['T_shipping'] = ''; // optional. Shipping Amount (######0.00)

        // recurring payment data
	    $formatted['T_recurring'] = ''; // optional. 1 => Add as a Recurring Transaction
	    $formatted['T_recurring_amount'] = ''; // optional. Recurring Amount
	    $formatted['T_recurring_type'] = ''; // optional. 1 => Monthly, 2 => Daily
	    $formatted['T_recurring_interval'] = ''; // optional. Recurring Interval
	    $formatted['T_recurring_non_business_days'] = ''; // optional. 0 => After, 1 => Before, 2 => That Day
	    $formatted['T_recurring_start_date'] = ''; // optional. Recurring Start Date MM/DD/YYYY
	    $formatted['T_recurring_indefinate'] = ''; // optional. 1 => Yes Indefinite, 0 => No
	    $formatted['T_recurring_times_to_process'] = ''; // optional. Times To Process the Recurring Transaction
	    $formatted['T_recurring_group'] = ''; // optional. Recurring Group ID to Add the Recurring Transaction under
	    $formatted['T_recurring_payment'] = ''; // optional. Merchant initiated recurring transaction


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
    curl_setopt($curlSession, CURLOPT_URL, 'https://gateway.sagepayments.net/cgi-bin/eftbankcard.dll?transaction');
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
    $response = curl_exec($curlSession);

    // Check that it actually reached the SagePay server
    // If it didn't, set the status as FAIL and the error as the cURL error
    if (curl_error($curlSession)) {
      $this->status = 'FAIL';
      $this->error = curl_error($curlSession);
    }

    // Close the cURL session
    curl_close($curlSession);


    $responseIndicator = $response[1];
    $responseCode = substr($response, 2, 6);


    if($responseIndicator == 'A') {

        $this->status = 'success';
        $parsedResponse = array(
            'response_code' => '1',
            'reason_text' => substr($response, 8, 32),
            'description' => substr($response, 8, 32)
        );
    } else if($responseIndicator == 'E') {

        $this->status = 'invalid';
        $this->error = substr($response, 8, 32);
        $parsedResponse = array(
            'response_code' => substr($response, 2, 6),
            'reason_text' => substr($response, 8, 32),
            'description' => substr($response, 8, 32)
        );
    } else { // 'X'

        $this->status = 'declined';
        $this->error = substr($response, 8, 32);
        $parsedResponse = array(
            'response_code' => substr($response, 2, 6),
            'reason_text' => substr($response, 8, 32),
            'description' => substr($response, 8, 32)
        );
    }



    $this->response = $parsedResponse;
  }

}
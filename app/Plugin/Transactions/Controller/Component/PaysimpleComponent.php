<?php
/**
 * @author Joel Byrnes <joel@razorit.com>
 */
App::uses('HttpSocket', 'Network/Http');
class PaysimpleComponent extends Component {

    public
	    $config = array(
		'environment' => 'sandbox',
		'apiUsername' => '',
		'sharedSecret' => '',
	    ),
	    $errors = false,
	    $response = array();

    public function __construct($config = array()) {
        parent::__construct($config);
        if(defined('__ORDERS_TRANSACTIONS_PAYSIMPLE')) {
            $settings = unserialize(__ORDERS_TRANSACTIONS_PAYSIMPLE);
	}

	$this->config = Set::merge($this->config, $config, $settings);

        $this->_httpSocket = new HttpSocket();
    }

    /**
     *
     * @param array $data
     */
    public function Pay($data) {

	$user = $this->findCustomerByEmail($data['Meta']['email']);

	if ($user) {
	    // we found this user..
	    // check if payment method exists
	    $currentAccounts = $this->getAccounts($user['Id']);
	    if($currentAccounts) {
		if(!empty($currentAccounts['CreditCardAccounts']) && isset($data['CreditCard']['card_number'])) {
		    $lastFourDigits = substr($data['CreditCard']['card_number'], -4, 4);
		    $accountExists = false;
		    foreach($currentAccounts['CreditCardAccounts'] as $creditCardAccount) {
			$ccLastFourDigits = substr($creditCardAccount['CreditCardNumber'], -4, 4);
			if($ccLastFourDigits == $lastFourDigits) {
			    $accountExists = true;
			    $accountId = $creditCardAccount['Id'];
			    break;
			}
		    }
		}
		if(!empty($currentAccounts['AchAccounts']) && isset($data['Ach']['achAccountNumber'])) {
		    $lastFourDigits = substr($data['Ach']['achAccountNumber'], -4, 4);
		    $accountExists = false;
		    foreach($currentAccounts['AchAccounts'] as $achAccount) {
			$achLastFourDigits = substr($achAccount['AccountNumber'], -4, 4);
			if($achLastFourDigits == $lastFourDigits) {
			    $accountExists = true;
			    $accountId = $achAccount['Id'];
			    break;
			}
		    }
		}
	    }

	    if(!isset($accountId)) {
		// this is a new payment method by an existing customer
		if(isset($data['CreditCard'])) {
		    // add their credit card
		    $params = array(
			'CreditCardNumber' => $data['CreditCard']['card_number'],
			'ExpirationDate' => $data['CreditCard']['expiration_month'].'-'.$data['CreditCard']['expiration_year'],
			'CustomerId' => $user['Id'],
		    );
		    $addCreditSuccess = $this->addCreditCardAccount($params);
		    if($addCreditSuccess) {
			$accountId = $addCreditSuccess['Id'];
		    }
		}
		if(isset($data['Ach'])) {
		    // add their ACH account
		    $params = array(
			'IsCheckingAccount' => $data['Ach']['achChecking'],
			'RoutingNumber' => $data['Ach']['achRoutingNumber'],
			'AccountNumber' => $data['Ach']['achAccountNumber'],
			'BankName' => $data['Ach']['achBankName'],
			'CustomerId' => $user['Id']
		    );
		    $addAchSuccess = $this->addAchAccount($params);
		    if($addAchSuccess) {
			$accountId = $addAchSuccess['Id'];
		    }
		}
	    }

	    if(isset($accountId)) {
		// proceed with the payment
		$params = array(
			'AccountId' => $accountId,
			'InvoiceId' => NULL,
			'Amount' => $data['Order']['theTotal'],
			'IsDebit' => false,
			'InvoiceNumber' => NULL,
			'PurchaseOrderNumber' => NULL,
			'OrderId' => NULL,
			'Description' => $data['Meta']['description'],
			'CVV' => $data['CreditCard']['cv_code'],
			'PaymentSubType' => 'Web',
			'Id' => 0
		);
		$paymentSuccess = $this->createPayment($params);
		if ($paymentSuccess) {
		    //$this->success = true;
		    $this->response['response_code'] = 1;
		} else {
		    $this->echoErrors();
		}
	    } else {
		$this->echoErrors();
	    }
	} else {

	    // user not found by email, create a new customer
	    $params = array(
		'FirstName' => $data['Billing']['first_name'],
		'LastName' => $data['Billing']['last_name'],
		//'Company' => $data['Meta']['company'],
		'BillingAddress' => array(
		    'StreetAddress1' => $data['Billing']['street_address_1'],
		    'StreetAddress2' => $data['Billing']['street_address_2'],
		    'City' => $data['Billing']['city'],
		    'StateCode' => $data['Billing']['state'],
		    'ZipCode' => $data['Billing']['zip'],
		),
		'ShippingSameAsBilling' => true,
		'Email' => $data['Meta']['email'],
		'Phone' => $data['Meta']['phone'],
	    );

	    $createSuccess = $this->createCustomer($params);
	    //var_dump($createSuccess);
	    if ($createSuccess) {

		if(isset($data['CreditCard'])) {
		    // add their credit card
		    $params = array(
			'CreditCardNumber' => $data['CreditCard']['card_number'],
			'ExpirationDate' => $data['CreditCard']['expiration_month'].'-'.$data['CreditCard']['expiration_year'],
			'CustomerId' => $createSuccess['Id'],
		    );
		    $addCreditSuccess = $this->addCreditCardAccount($params);
		    if($addCreditSuccess) {
			$accountId = $addCreditSuccess['Id'];
		    }
		}
		if(isset($data['Ach'])) {
		    // add their ACH account
		    $params = array(
			'IsCheckingAccount' => $data['Ach']['achChecking'],
			'RoutingNumber' => $data['Ach']['achRoutingNumber'],
			'AccountNumber' => $data['Ach']['achAccountNumber'],
			'BankName' => $data['Ach']['achBankName'],
			'CustomerId' => $createSuccess['Id']
		    );
		    $addAchSuccess = $this->addAchAccount($params);
		    if($addAchSuccess) {
			$accountId = $addAchSuccess['Id'];
		    }
		}

		// now process the payment
		if ($accountId) {
		    $params = array(
			'AccountId' => $accountId,
			'InvoiceId' => NULL,
			'Amount' => $data['Order']['theTotal'],
			'IsDebit' => false,
			'InvoiceNumber' => NULL,
			'PurchaseOrderNumber' => NULL,
			'OrderId' => NULL,
			'Description' => $data['Meta']['description'],
			'CVV' => $data['CreditCard']['cv_code'],
			'PaymentSubType' => 'Web',
			'Id' => 0
		    );
		    $paymentSuccess = $this->createPayment($params);
		    if ($paymentSuccess) {
			//$this->success = true;
			$this->response['response_code'] = 1;
		    } else { //echo '290';
			$this->echoErrors();
		    }
		} else { //echo '293';
		    $this->echoErrors();
		}
	    } else { //echo '296';
		$this->echoErrors();
	    }

	}
    }

    /**
     *
     * @return boolean|array
     */
    public function getCustomerList() {
	return $this->_sendRequest('GET', '/customer');
    }

    /**
     *
     * @param array $data
     * @return boolean|array
     */
    public function createCustomer($data) {
	return $this->_sendRequest('POST', '/customer', $data);
    }

    /**
     *
     * @param integer $userId
     * @return boolean|array
     */
    public function getAccounts($userId) {
	return $this->_sendRequest('GET', '/customer/'.$userId.'/accounts');
    }

    /**
     *
     * @param array $data
     * @return boolean|array
     */
    public function addCreditCardAccount($data) {

	$data['Id'] = 0;
	$data['IsDefault'] = true;
	$data['Issuer'] = $this->getIssuer($data['CreditCard']['card_number']);

	return $this->_sendRequest('POST', '/account/creditcard', $data);
    }

    /**
     *
     * @param array $data
     * @return boolean|array
     */
    public function addAchAccount($data) {

	$data['Id'] = 0;
	$data['IsDefault'] = true;

	return $this->_sendRequest('POST', '/account/ach', $data);
    }

    /**
     *
     * @param array $data
     * @return boolean|array
     */
    public function createPayment($data) {
	return $this->_sendRequest('POST', '/payment', $data);
    }


    /**
     * try to find their email in the current customer list
     * @param string $email
     * @return boolean|array
     */
    public function findCustomerByEmail($email) {
	$customerList = $this->getCustomerList();
	if ($customerList) {
	    foreach ($customerList as $customer) {
		if ($customer['Email'] == $email) {
		    $user = $customer;
		    break;
		}
	    }
	}
	if($user) {
	    return $user;
	} else {
	    return FALSE;
	}
    }


    /**
     * This function executes upon failure
     */
    public function echoErrors() {debug($this->errors);
	foreach ($this->errors as $error) {
	    $this->response['reason_text'] .= '<li>' . $error . '</li>';
	}
	$this->response['response_code'] = 0;
    }

    /**
     *
     * @param type $cardNumber
     * @return boolean|integer
     */
    public function getIssuer($cardNumber) {

	App::uses('Validation', 'Utility');
	if (Validation::cc($cardNumber, 'visa')) {
	    $cardType = 'Visa';
	} elseif (Validation::cc($cardNumber, 'amex')) {
	    $cardType = 'Amex';
	} elseif (Validation::cc($cardNumber, 'mc')) {
	    $cardType = 'Master';
	} elseif (Validation::cc($cardNumber, 'disc')) {
	    $cardType = 'Discover';
	} else {
	    $cardType = 'Unsupported';
	}

	$paySimpleCodes = array(
	    'Unsupported' => FALSE,
	    'Visa' => 12,
	    'Discover' => 15,
	    'Master' => 13,
	    'Amex' => 14,
	);

	return $paySimpleCodes[$CreditCardType];
    }

    /**
     *
     * @param string $method
     * @param string $action
     * @param array $data
     * @return boolean|array
     */
    public function _sendRequest($method, $action, $data = NULL) {

	if ($this->config['environment'] == 'sandbox') {
	    $endpoint = 'https://sandbox-api.paysimple.com/v4';
	} else {
	    $endpoint = 'https://api.paysimple.com/v4';
	}

	$timestamp = gmdate("c");
	$hmac = hash_hmac("sha256", $timestamp, $this->config['sharedSecret'], true); //note the raw output parameter
	$hmac = base64_encode($hmac);

	$auth[] = "Authorization: PSSERVER AccessId = {$this->config['apiUsername']}; Timestamp = {$timestamp}; Signature = {$hmac};";

        $request = array(
            'method' => $method,
            'uri' => $endpoint . $action,
            'header' => array(
                'Authorization' => 'PSSERVER AccessId = '.$this->config['apiUsername'],
                'Timestamp' => $timestamp,
                'Signature' => $hmac
            ),

        );
	if ($data !== NULL) {
	    $data = json_encode($data);
	    $request['header']['Content-Type'] = 'application/json';
	    $request['header']['Content-Length'] = strlen($data);
	    $request['body'] = $data;
	}

	$result = $this->_httpSocket->request($request);debug($result);
	$responseCode = $result->code;
	$result = json_decode($result->body, TRUE);
debug($request);
debug($responseCode);
break;
	$badResponseCodes = array(400, 401, 403, 404, 405, 500);
	if (in_array($responseCode, $badResponseCodes)) {
	    if(is_string($result)) {
		$this->errors[] = $result;
	    } elseif(isset($result['Meta']['Errors']['ErrorMessages'])) {
		foreach ($result['Meta']['Errors']['ErrorMessages'] as $error) {
		    $this->errors[] = $error['Message'];
		}
	    } else {
		$this->errors[] = $result;
	    }
	    return FALSE;
	} else {
	    return $result['Response'];
	}
    }

}
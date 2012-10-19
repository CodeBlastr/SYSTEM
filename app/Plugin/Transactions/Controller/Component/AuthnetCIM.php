<?php
class AuthnetCIM
{
    const USE_PRODUCTION_SERVER  = 0;
    const USE_DEVELOPMENT_SERVER = 1;

    const EXCEPTION_CURL = 10;

    private $params  = array();
    private $items   = array();
    private $success = false;
    private $error   = true;

    private $login;
    private $transkey;
    private $xml;
    private $ch;
    private $response;
    private $url;
    private $resultCode;
    private $code;
    private $text;
    private $profileId;
    private $validation;
    private $paymentProfileId;
    private $results;
    public $paymentProfiles;

    public function __construct($login, $transkey, $test = self::USE_PRODUCTION_SERVER)
    {
        $this->login    = trim($login);
        $this->transkey = trim($transkey);
        if (empty($this->login) || empty($this->transkey))
        {
            //trigger_error('You have not configured your ' . __CLASS__ . '() login credentials properly.', E_USER_ERROR);
        }

        $this->test = (bool) $test;
        $subdomain  = ($this->test) ? 'apitest' : 'api';
        $this->url = 'https://' . $subdomain . '.authorize.net/xml/v1/request.api';

        $this->request->params['customerType']     = 'individual';
        $this->request->params['validationMode']   = 'liveMode';
        $this->request->params['taxExempt']        = 'false';
        $this->request->params['recurringBilling'] = 'false';
    }

    public function __destruct()
    {
        if (isset($this->ch))
        {
            curl_close($this->ch);
        }
    }

    public function __toString()
    {
        if (!$this->request->params)
        {
            return (string) $this;
        }
        $output  = '<table summary="Authnet Results" id="authnet">' . "\n";
        $output .= '<tr>' . "\n\t\t" . '<th colspan="2"><b>Outgoing Parameters</b></th>' . "\n" . '</tr>' . "\n";
        foreach ($this->request->params as $key => $value)
        {
            $output .= "\t" . '<tr>' . "\n\t\t" . '<td><b>' . $key . '</b></td>';
            $output .= '<td>' . $value . '</td>' . "\n" . '</tr>' . "\n";
        }

        $output .= '</table>' . "\n";
        if (!empty($this->xml))
        {
            $output .= 'XML: ';
            $output .= htmlentities($this->xml);
        }
        return $output;
    }

    private function process()
    {
        $this->ch = curl_init();
        curl_setopt($this->ch, CURLOPT_URL, $this->url);
    	curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
    	curl_setopt($this->ch, CURLOPT_HTTPHEADER, Array("Content-Type: text/xml"));
    	curl_setopt($this->ch, CURLOPT_HEADER, 0);
    	curl_setopt($this->ch, CURLOPT_POSTFIELDS, $this->xml);
    	curl_setopt($this->ch, CURLOPT_POST, 1);
    	curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, 0);
        $this->response = curl_exec($this->ch);
        if($this->response)
        {
            $this->parseResults();
            if ($this->resultCode === 'Ok')
            {
                $this->success = true;
                $this->error   = false;
            }
            else
            {
                $this->success = false;
                $this->error   = true;
            }
            curl_close($this->ch);
            unset($this->ch);
        }
        else
        {
            throw new AuthnetCIMException('Connection error: ' . curl_error($this->ch) . ' (' . curl_errno($this->ch) . ')', self::EXCEPTION_CURL);
        }
    }

    public function createCustomerProfile($use_profiles = false, $type = 'credit')
    {
        $this->xml = '<?xml version="1.0" encoding="utf-8"?>
                      <createCustomerProfileRequest xmlns="AnetApi/xml/v1/schema/AnetApiSchema.xsd">
                          <merchantAuthentication>
                              <name>' . $this->login . '</name>
                              <transactionKey>' . $this->transkey . '</transactionKey>
                          </merchantAuthentication>';
        if (!empty($this->request->params['refId']))
        {
            $this->xml .= '
                          <refId>'. $this->request->params['refId'] .'</refId>';
        }
            $this->xml .= '
                          <profile>
                              <merchantCustomerId>'. $this->request->params['merchantCustomerId'].'</merchantCustomerId>';

        if ($use_profiles == true)
        {
            $this->xml .= '
                              <paymentProfiles>
                                  <customerType>'. $this->request->params['customerType'].'</customerType>
                                  <billTo>
                                      <firstName>'. $this->request->params['billToFirstName'].'</firstName>
                                      <lastName>'. $this->request->params['billToLastName'].'</lastName>
                                      <address>'. $this->request->params['billToAddress'] .'</address>
                                      <city>'. $this->request->params['billToCity'] .'</city>
                                      <state>'. $this->request->params['billToState'] .'</state>
                                      <zip>'. $this->request->params['billToZip'] .'</zip>
                                      <country>'. $this->request->params['billToCountry'] .'</country>
                                  </billTo>
                                  <payment>';
            if ($type === 'credit')
            {
                $this->xml .= '
                                      <creditCard>
                                          <cardNumber>'. $this->request->params['cardNumber'].'</cardNumber>
                                          <expirationDate>'.$this->request->params['expirationDate'].'</expirationDate>
                                      </creditCard>';
            }
            else if ($type === 'check')
            {
                $this->xml .= '
                                      <bankAccount>
                                          <accountType>'.$this->request->params['accountType'].'</accountType>
                                          <nameOnAccount>'.$this->request->params['nameOnAccount'].'</nameOnAccount>
                                          <echeckType>'. $this->request->params['echeckType'].'</echeckType>
                                          <bankName>'. $this->request->params['bankName'].'</bankName>
                                          <routingNumber>'.$this->request->params['routingNumber'].'</routingNumber>
                                          <accountNumber>'.$this->request->params['accountNumber'].'</accountNumber>
                                      </bankAccount>
                                      <driversLicense>
                                          <dlState>'. $this->request->params['dlState'].'</dlState>
                                          <dlNumber>'. $this->request->params['dlNumber'].'</dlNumber>
                                          <dlDateOfBirth>'.$this->request->params['dlDateOfBirth'].'</dlDateOfBirth>
                                      </driversLicense>';
            }
            $this->xml .= '
                                  </payment>
                              </paymentProfiles>
                              <shipToList>
                                  <firstName>'. $this->request->params['shipToFirstName'].'</firstName>
                                  <lastName>'. $this->request->params['shipToLastName'].'</lastName>
                                  <address>'. $this->request->params['shipToAddress'] .'</address>
                                  <city>'. $this->request->params['shipToCity'] .'</city>
                                  <state>'. $this->request->params['shipToState'] .'</state>
                                  <zip>'. $this->request->params['shipToZip'] .'</zip>
                                  <country>'. $this->request->params['shipToCountry'] .'</country>
                              </shipToList>';
        }
            $this->xml .= '
                          </profile>
                      </createCustomerProfileRequest>';
        $this->process();
    }

    public function createCustomerPaymentProfile($type = 'credit')
    {
        $this->xml = '<?xml version="1.0" encoding="utf-8"?>
                      <createCustomerPaymentProfileRequest xmlns="AnetApi/xml/v1/schema/AnetApiSchema.xsd">
                          <merchantAuthentication>
                              <name>' . $this->login . '</name>
                              <transactionKey>' . $this->transkey . '</transactionKey>
                          </merchantAuthentication>
                          <customerProfileId>'. $this->request->params['customerProfileId'].'</customerProfileId>
                          <paymentProfile>
                              <customerType>'. $this->request->params['customerType'].'</customerType>
                              <billTo>
                                  <firstName>'. $this->request->params['billToFirstName'].'</firstName>
                                  <lastName>'. $this->request->params['billToLastName'].'</lastName>
                                  <address>'. $this->request->params['billToAddress'] .'</address>
                                  <city>'. $this->request->params['billToCity'] .'</city>
                                  <state>'. $this->request->params['billToState'] .'</state>
                                  <zip>'. $this->request->params['billToZip'] .'</zip>
                                  <country>'. $this->request->params['billToCountry'] .'</country>
                              </billTo>
                              <payment>';
        if ($type === 'credit')
        {
            $this->xml .= '
                                  <creditCard>
                                      <cardNumber>'. $this->request->params['cardNumber'].'</cardNumber>
                                      <expirationDate>'.$this->request->params['expirationDate'].'</expirationDate>
                                  </creditCard>';
        }
        else if ($type === 'check')
        {
            $this->xml .= '
                                  <bankAccount>
                                      <accountType>'. $this->request->params['accountType'].'</accountType>
                                      <nameOnAccount>'.$this->request->params['nameOnAccount'].'</nameOnAccount>
                                      <echeckType>'. $this->request->params['echeckType'].'</echeckType>
                                      <bankName>'. $this->request->params['bankName'].'</bankName>
                                      <routingNumber>'.$this->request->params['routingNumber'].'</routingNumber>
                                      <accountNumber>'.$this->request->params['accountNumber'].'</accountNumber>
                                  </bankAccount>
                                  <driversLicense>
                                      <dlState>'. $this->request->params['dlState'] .'</dlState>
                                      <dlNumber>'. $this->request->params['dlNumber'].'</dlNumber>
                                      <dlDateOfBirth>'.$this->request->params['dlDateOfBirth'].'</dlDateOfBirth>
                                  </driversLicense>';
        }
        $this->xml .= '
                              </payment>
                          </paymentProfile>
                          <validationMode>'. $this->request->params['validationMode'].'</validationMode>
                      </createCustomerPaymentProfileRequest>';
        $this->process();
    }

    public function createCustomerShippingAddress()
    {
        $this->xml = '<?xml version="1.0" encoding="utf-8"?>
                      <createCustomerShippingAddressRequest xmlns="AnetApi/xml/v1/schema/AnetApiSchema.xsd">
                          <merchantAuthentication>
                              <name>' . $this->login . '</name>
                              <transactionKey>' . $this->transkey . '</transactionKey>
                          </merchantAuthentication>
                          <refId>'. $this->request->params['refId'] .'</refId>
                          <customerProfileId>'. $this->request->params['customerProfileId'].'</customerProfileId>
                          <address>
                              <firstName>'. $this->request->params['shipToFirstName'].'</firstName>
                              <lastName>'. $this->request->params['shipToLastName'].'</lastName>
                              <company>'. $this->request->params['shipToCompany'] .'</company>
                              <address>'. $this->request->params['shipToAddress'] .'</address>
                              <city>'. $this->request->params['shipToCity'] .'</city>
                              <state>'. $this->request->params['shipToState'] .'</state>
                              <zip>'. $this->request->params['shipToZip'] .'</zip>
                              <country>'. $this->request->params['shipToCountry'] .'</country>
                              <phoneNumber>'. $this->request->params['shipToPhoneNumber'].'</phoneNumber>
                              <faxNumber>'. $this->request->params['shipToFaxNumber'].'</faxNumber>
                          </address>
                      </createCustomerShippingAddressRequest>';
        $this->process();
    }

    public function createCustomerProfileTransaction($type = 'profileTransAuthCapture')
    {
        $types = array('profileTransAuthCapture', 'profileTransCaptureOnly','profileTransAuthOnly');
        if (!in_array($type, $types))
        {
            trigger_error('createCustomerProfileTransaction() parameter must be"profileTransAuthCapture", "profileTransCaptureOnly", "profileTransAuthOnly", or empty', E_USER_ERROR);
        }

        $this->xml = '<?xml version="1.0" encoding="utf-8"?>
                      <createCustomerProfileTransactionRequest xmlns="AnetApi/xml/v1/schema/AnetApiSchema.xsd">
                          <merchantAuthentication>
                              <name>' . $this->login . '</name>
                              <transactionKey>' . $this->transkey . '</transactionKey>
                          </merchantAuthentication>
                          <refId>'. $this->request->params['refId'] .'</refId>
                          <transaction>
                              <' . $type . '>
                                  <amount>'. $this->request->params['amount'] .'</amount>';
        if (isset($this->request->params['taxAmount']))
        {
            $this->xml .= '
                                  <tax>
                                       <amount>'. $this->request->params['taxAmount'].'</amount>
                                       <name>'. $this->request->params['taxName'] .'</name>
                                       <description>'.$this->request->params['taxDescription'].'</description>
                                  </tax>';
        }
        if (isset($this->request->params['shipAmount']))
        {
            $this->xml .= '
                                  <shipping>
                                       <amount>'. $this->request->params['shipAmount'].'</amount>
                                       <name>'. $this->request->params['shipName'] .'</name>
                                       <description>'.$this->request->params['shipDescription'].'</description>
                                  </shipping>';
        }
        if (isset($this->request->params['dutyAmount']))
        {
            $this->xml .= '
                                  <duty>
                                       <amount>'. $this->request->params['dutyAmount'].'</amount>
                                       <name>'. $this->request->params['dutyName'] .'</name>
                                       <description>'.$this->request->params['dutyDescription'].'</description>
                                  </duty>';
        }
        $this->xml .= '
                                  <customerProfileId>'.$this->request->params['customerProfileId'].'</customerProfileId>
                                  <customerPaymentProfileId>'.$this->request->params['customerPaymentProfileId'].'</customerPaymentProfileId>';
        if (isset($this->request->params['orderInvoiceNumber']))
        {
            $this->xml .= '
                                  <order>
                                       <invoiceNumber>'.$this->request->params['invoiceNumber'].'</orderInvoiceNumber>
                                       <description>'.$this->request->params['description'].'</orderDescription>
                                       <purchaseOrderNumber>'.$this->request->params['purchaseOrderNumber'].'</orderPurchaseOrderNumber>
                                  </order>';
        }
        $this->xml .= '
                                  <taxExempt>'. $this->request->params['taxExempt'].'</taxExempt>
                                  <recurringBilling>'.$this->request->params['recurringBilling'].'</recurringBilling>
                                  <cardCode>'. $this->request->params['cardCode'].'</cardCode>';
        if (isset($this->request->params['orderInvoiceNumber']))
        {
            $this->xml .= '
                                  <approvalCode>'. $this->request->params['approvalCode'].'</approvalCode>';
        }
        $this->xml .= '
                              </' . $type . '>
                          </transaction>
                      </createCustomerProfileTransactionRequest>';
        $this->process();
    }

    public function deleteCustomerProfile()
    {
        $this->xml = '<?xml version="1.0" encoding="utf-8"?>
                      <deleteCustomerProfileRequest xmlns="AnetApi/xml/v1/schema/AnetApiSchema.xsd">
                          <merchantAuthentication>
                              <name>' . $this->login . '</name>
                              <transactionKey>' . $this->transkey . '</transactionKey>
                          </merchantAuthentication>
                          <refId>'. $this->request->params['refId'] .'</refId>
                          <customerProfileId>'. $this->request->params['customerProfileId'].'</customerProfileId>
                      </deleteCustomerProfileRequest>';
        $this->process();
    }

    public function deleteCustomerPaymentProfile()
    {
        $this->xml = '<?xml version="1.0" encoding="utf-8"?>
                      <deleteCustomerPaymentProfileRequest xmlns="AnetApi/xml/v1/schema/AnetApiSchema.xsd">
                          <merchantAuthentication>
                              <name>' . $this->login . '</name>
                              <transactionKey>' . $this->transkey . '</transactionKey>
                          </merchantAuthentication>
                          <refId>'. $this->request->params['refId'] .'</refId>
                          <customerProfileId>'. $this->request->params['customerProfileId'].'</customerProfileId>
                          <customerPaymentProfileId>'.$this->request->params['customerPaymentProfileId'].'</customerPaymentProfileId>
                      </deleteCustomerPaymentProfileRequest>';
        $this->process();
    }

    public function deleteCustomerShippingAddress()
    {
        $this->xml = '<?xml version="1.0" encoding="utf-8"?>
                      <deleteCustomerShippingAddressRequest xmlns="AnetApi/xml/v1/schema/AnetApiSchema.xsd">
                          <merchantAuthentication>
                              <name>' . $this->login . '</name>
                              <transactionKey>' . $this->transkey . '</transactionKey>
                          </merchantAuthentication>
                          <refId>'. $this->request->params['refId'] .'</refId>
                          <customerProfileId>'. $this->request->params['customerProfileId'].'</customerProfileId>
                          <customerAddressId>'. $this->request->params['customerAddressId'].'</customerAddressId>
                      </deleteCustomerShippingAddressRequest>';
        $this->process();
    }

    public function getCustomerProfile()
    {
        $this->xml = '<?xml version="1.0" encoding="utf-8"?>
                      <getCustomerProfileRequest xmlns="AnetApi/xml/v1/schema/AnetApiSchema.xsd">
                          <merchantAuthentication>
                              <name>' . $this->login . '</name>
                              <transactionKey>' . $this->transkey . '</transactionKey>
                          </merchantAuthentication>
                          <customerProfileId>'. $this->request->params['customerProfileId'].'</customerProfileId>
                      </getCustomerProfileRequest>';
        $this->process();
    }

    public function getCustomerPaymentProfile()
    {
        $this->xml = '<?xml version="1.0" encoding="utf-8"?>
                      <getCustomerPaymentProfileRequest xmlns="AnetApi/xml/v1/schema/AnetApiSchema.xsd">
                          <merchantAuthentication>
                              <name>' . $this->login . '</name>
                              <transactionKey>' . $this->transkey . '</transactionKey>
                          </merchantAuthentication>
                          <customerProfileId>'. $this->request->params['customerProfileId'].'</customerProfileId>
                          <customerPaymentProfileId>'.$this->request->params['customerPaymentProfileId'].'</customerPaymentProfileId>
                      </getCustomerPaymentProfileRequest>';
        $this->process();
    }

    public function getCustomerShippingAddress()
    {
        $this->xml = '<?xml version="1.0" encoding="utf-8"?>
                      <getCustomerShippingAddressRequest xmlns="AnetApi/xml/v1/schema/AnetApiSchema.xsd">
                          <merchantAuthentication>
                              <name>' . $this->login . '</name>
                              <transactionKey>' . $this->transkey . '</transactionKey>
                          </merchantAuthentication>
                              <customerProfileId>'.$this->request->params['customerProfileId'].'</customerProfileId>
                              <customerAddressId>'.$this->request->params['customerAddressId'].'</customerAddressId>
                      </getCustomerShippingAddressRequest>';
        $this->process();
    }

    public function updateCustomerProfile()
    {
        $this->xml = '<?xml version="1.0" encoding="utf-8"?>
                      <updateCustomerProfileRequest xmlns="AnetApi/xml/v1/schema/AnetApiSchema.xsd">
                          <merchantAuthentication>
                              <name>' . $this->login . '</name>
                              <transactionKey>' . $this->transkey . '</transactionKey>
                          </merchantAuthentication>
                          <refId>'. $this->request->params['refId'] .'</refId>
                          <profile>
                              <merchantCustomerId>'.$this->request->params['merchantCustomerId'].'</merchantCustomerId>
                              <description>'. $this->request->params['description'].'</description>
                              <email>'. $this->request->params['email'] .'</email>
                              <customerProfileId>'.$this->request->params['customerProfileId'].'</customerProfileId>
                          </profile>
                      </updateCustomerProfileRequest>';
        $this->process();
    }

    public function updateCustomerPaymentProfile($type = 'credit')
    {
        $this->xml = '<?xml version="1.0" encoding="utf-8"?>
                      <updateCustomerPaymentProfileRequest xmlns="AnetApi/xml/v1/schema/AnetApiSchema.xsd">
                          <merchantAuthentication>
                              <name>' . $this->login . '</name>
                              <transactionKey>' . $this->transkey . '</transactionKey>
                          </merchantAuthentication>
                          <refId>'. $this->request->params['refId'] .'</refId>
                          <customerProfileId>'. $this->request->params['customerProfileId'].'</customerProfileId>
                          <paymentProfile>
                              <customerType>'. $this->request->params['customerType'].'</customerType>
                              <billTo>
                                  <firstName>'. $this->request->params['firstName'].'</firstName>
                                  <lastName>'. $this->request->params['lastName'] .'</lastName>
                                  <company>'. $this->request->params['company'] .'</company>
                                  <address>'. $this->request->params['address'] .'</address>
                                  <city>'. $this->request->params['city'] .'</city>
                                  <state>'. $this->request->params['state'] .'</state>
                                  <zip>'. $this->request->params['zip'] .'</zip>
                                  <country>'. $this->request->params['country'] .'</country>
                                  <phoneNumber>'. $this->request->params['phoneNumber'].'</phoneNumber>
                                  <faxNumber>'. $this->request->params['faxNumber'].'</faxNumber>
                              </billTo>
                              <payment>';
        if ($type === 'credit')
        {
            $this->xml .= '
                                  <creditCard>
                                      <cardNumber>'. $this->request->params['cardNumber'].'</cardNumber>
                                      <expirationDate>'.$this->request->params['expirationDate'].'</expirationDate>
                                  </creditCard>';
        }
        else if ($type === 'check')
        {
            $this->xml .= '
                                  <bankAccount>
                                      <accountType>'.$this->request->params['accountType'].'</accountType>
                                      <nameOnAccount>'.$this->request->params['nameOnAccount'].'</nameOnAccount>
                                      <echeckType>'. $this->request->params['echeckType'].'</echeckType>
                                      <bankName>'. $this->request->params['bankName'].'</bankName>
                                      <routingNumber>'.$this->request->params['routingNumber'].'</routingNumber>
                                      <accountNumber>'.$this->request->params['accountNumber'].'</accountNumber>
                                  </bankAccount>
                                  <driversLicense>
                                      <dlState>'. $this->request->params['dlState'].'</dlState>
                                      <dlNumber>'. $this->request->params['dlNumber'].'</dlNumber>
                                      <dlDateOfBirth>'.$this->request->params['dlDateOfBirth'].'</dlDateOfBirth>
                                  </driversLicense>';
        }
        $this->xml .= '
                              </payment>
                              <customerPaymentProfileId>'.$this->request->params['customerPaymentProfileId'].'</customerPaymentProfileId>
                          </paymentProfile>
                      </updateCustomerPaymentProfileRequest>';
        $this->process();
    }

    public function updateCustomerShippingAddress()
    {
        $this->xml = '<?xml version="1.0" encoding="utf-8"?>
                      <updateCustomerShippingAddressRequest xmlns="AnetApi/xml/v1/schema/AnetApiSchema.xsd">
                          <merchantAuthentication>
                              <name>' . $this->login . '</name>
                              <transactionKey>' . $this->transkey . '</transactionKey>
                          </merchantAuthentication>
                          <refId>'. $this->request->params['refId'] .'</refId>
                          <customerProfileId>'. $this->request->params['customerProfileId'].'</customerProfileId>
                          <address>
                              <firstName>'. $this->request->params['firstName'] .'</firstName>
                              <lastName>'. $this->request->params['lastName'] .'</lastName>
                              <company>'. $this->request->params['company'] .'</company>
                              <address>'. $this->request->params['address'] .'</address>
                              <city>'. $this->request->params['city'] .'</city>
                              <state>'. $this->request->params['state'] .'</state>
                              <zip>'. $this->request->params['zip'] .'</zip>
                              <country>'. $this->request->params['country'] .'</country>
                              <phoneNumber>'. $this->request->params['phoneNumber'].'</phoneNumber>
                              <faxNumber>'. $this->request->params['faxNumber'] .'</faxNumber>
                              <customerAddressId>'.$this->request->params['customerAddressId'].'</customerAddressId>
                          </address>
                      </updateCustomerShippingAddressRequest>';
        $this->process();
    }

    public function validateCustomerPaymentProfile()
    {
        $this->xml = '<?xml version="1.0" encoding="utf-8"?>
                      <validateCustomerPaymentProfileRequest xmlns="AnetApi/xml/v1/schema/AnetApiSchema.xsd">
                          <merchantAuthentication>
                              <name>' . $this->login . '</name>
                              <transactionKey>' . $this->transkey . '</transactionKey>
                          </merchantAuthentication>
                          <customerProfileId>'. $this->request->params['customerProfileId'].'</customerProfileId>
                          <customerPaymentProfileId>'.$this->request->params['customerPaymentProfileId'].'</customerPaymentProfileId>
                          <customerAddressId>'. $this->request->params['customerAddressId'].'</customerAddressId>
                          <validationMode>'. $this->request->params['validationMode'].'</validationMode>
                      </validateCustomerPaymentProfileRequest>';
        $this->process();
    }

    private function getLineItems()
    {
        $tempXml = '';
        foreach ($this->items as $item)
        {
            foreach ($item as $key => $value)
            {
                $tempXml .= "\t" . '<' . $key . '>' . $value . '</' . $key . '>' . "\n";
            }
        }
        return $tempXml;
    }

    public function setLineItem($itemId, $name, $description, $quantity, $unitprice,$taxable = 'false')
    {
        $this->items[] = array('itemId' => $itemId, 'name' => $name, 'description' => $description, 'quantity' => $quantity, 'unitPrice' => $unitprice, 'taxable' => $taxable);
    }

    public function setParameter($field = '', $value = null)
    {
        $field = (is_string($field)) ? trim($field) : $field;
        $value = (is_string($value)) ? trim($value) : $value;
        if (!is_string($field))
        {
            trigger_error(__METHOD__ . '() arg 1 must be a string: ' . gettype($field) . ' given.', E_USER_ERROR);
        }
        if (empty($field))
        {
            trigger_error(__METHOD__ . '() requires a parameter field to be named.', E_USER_ERROR);
        }
        if (!is_string($value) && !is_numeric($value) && !is_bool($value))
        {
            trigger_error(__METHOD__ . '() arg 2 (' . $field . ') must be a string, integer, or boolean value: ' . gettype($value) . ' given.', E_USER_ERROR);
        }
        if ($value === '' || is_null($value))
        {
            trigger_error(__METHOD__ . '() parameter "value" is empty or missing (parameter: ' . $field . ').', E_USER_NOTICE);
        }
        $this->request->params[$field] = $value;
    }

    private function parseResults()
    {
        $response = str_replace('xmlns="AnetApi/xml/v1/schema/AnetApiSchema.xsd"', '', $this->response);
        $xml = new SimpleXMLElement($response);

        $this->resultCode       = (string) $xml->messages->resultCode;
        $this->code             = (string) $xml->messages->message->code;
        $this->text             = (string) $xml->messages->message->text;
        $this->validation       = (string) $xml->validationDirectResponse;
        $this->directResponse   = (string) $xml->directResponse;
        $this->profileId        = (int) $xml->customerProfileId;
        $this->addressId        = (int) $xml->customerAddressId;
        $this->paymentProfileId = (int) $xml->customerPaymentProfileId;
        $this->paymentProfiles	= (Array) $xml->profile;
        //$this->results          = explode(',', $this->directResponse);
        $this->results          = explode(',', $xml->validationDirectResponse);
    }

    public function isSuccessful()
    {
        return $this->success;
    }

    public function isError()
    {
        return $this->error;
    }

    public function getResponseSummary()
    {
        return 'Response code: ' . $this->getCode() . ' Message: ' . $this->getResponse();
    }

    public function getResponse()
    {
        return strip_tags($this->text);
    }

    public function getCode()
    {
        return $this->code;
    }

    public function getProfileID()
    {
        return $this->profileId;
    }

    public function validationDirectResponse()
    {
        return $this->validation;
    }

    public function getCustomerAddressId()
    {
        return $this->addressId;
    }

    public function getDirectResponse()
    {
        return $this->directResponse;
    }

    public function getPaymentProfileId()
    {
        return $this->paymentProfileId;
    }

	public function getResponseCode()
    {
        return $this->results[0];
    }
    
    public function getResponseSubcode()
    {
        return $this->results[1];
    }

    public function getReasonCode()
    {
        return $this->results[2];
    }

    public function getResponseText()
    {
        return $this->results[3];
    }

    public function getAuthCode()
    {
        return $this->results[4];
    }

    public function getAVSResponse()
    {
        return $this->results[5];
    }

    public function getTransactionID()
    {
        return $this->results[6];
    }

	public function getDescription()
    {
        return $this->results[8];
    }
    
    public function getCVVResponse()
    {
        return $this->results[38];
    }

    public function getCAVVResponse()
    {
        return $this->results[39];
    }
    
	public function getTransactionType()
    {
        return $this->results[11];
    }
    
	public function getPaymentProfiles()
    {
        return $this->paymentProfiles;
    }
};

class AuthnetCIMException extends Exception {};
?>
<?PHP

/**
 * Paypal Datasource
 *
 * @author Joel Byrnes <joel@razorit.com>
 *
 */
App::import('Core', array('Xml', 'HttpSocket'));

class PaypalSource extends Datasource {

    public $description = 'Paypal API';
    public $useDbConfig = 'paypal';
    private $_httpSocket = null;
    public $config = array(
        'environment' => 'sandbox',
        'api_username' => '',
        'api_password' => '',
        'api_signature' => '',
        'app_id' => '',
        'scope' => array('ACCOUNT_BALANCE')
    );

    public function __construct($config = array()) {
        parent::__construct($config);
        $this->config = array_merge($this->config, $config);
        if($this->config['environment'] == 'sandbox') {
            $this->config['endpoint'] = 'https://svcs.sandbox.paypal.com';
            $this->config['nvpEndpoint'] = 'https://api-3t.sandbox.paypal.com/nvp';
        } else { /** @todo Set the live PayPal endpoints **/
            $this->config['endpoint'] = 'https://svcs.paypal.com';
            $this->config['nvpEndpoint'] = 'https://api-3t.sandbox.paypal.com/nvp';
        }
        $this->_httpSocket = new HttpSocket();
    }

    /**
     * This is our base Permissions API request sender.
     * @param string $apiOperation
     * @param type $query
     * @return array
     */
    public function sendRequest($apiOperation, $query) {

        $query['requestEnvelope.errorLanguage'] = 'en_US';

        $request = array(
            'header' => array(
                'X-PAYPAL-SECURITY-USERID' => $this->config['api_username'],
                'X-PAYPAL-SECURITY-PASSWORD' => $this->config['api_password'],
                'X-PAYPAL-SECURITY-SIGNATURE' => $this->config['api_signature'],
                'X-PAYPAL-REQUEST-DATA-FORMAT' => 'JSON',
                'X-PAYPAL-RESPONSE-DATA-FORMAT' => 'JSON',
                'X-PAYPAL-APPLICATION-ID' => $this->config['app_id'],
            )
        );
        if(strstr($this->config['endpoint'], 'sandbox'))
                $request['header']['X-PAYPAL-SANDBOX-EMAIL-ADDRESS'] = 'paypal-sandboxer@razorit.com';
        
        $results = $this->_httpSocket->post($this->config['endpoint'].$apiOperation, $query, $request);
	return $this->_ackHandler(json_decode($results));
    }
    
    
    /**
     * This is our base NVP request sender.
     * @param string $apiOperation
     * @param type $query
     * @return array
     */
    public function sendNvpRequest($method, $query) {

        $query['METHOD'] = $method;
        $query['VERSION'] = '51.0';
        $query['USER'] = $this->config['api_username'];
        $query['PWD'] = $this->config['api_password'];
        $query['SIGNATURE'] = $this->config['api_signature'];

        $results = $this->_httpSocket->post($this->config['nvpEndpoint'], $query);
	return $this->_ackHandler(json_decode($results));
    }

    /**
     * A Pass/Fail response parser with error/warning logging capability
     * @param array $result
     * @return boolean
     */
    private function _ackHandler($result) {
        $ackCodes = array(
            'Success' => array(
                'okay' => true,
                'log' => false
            ),
            'Failure' => array(
                'okay' => false,
                'log' => true
            ),
            'Warning' => array(
                'okay' => false,//???
                'log' => true
            ),
            'SuccessWithWarning' => array(
                'okay' => true,
                'log' => true
            ),
            'FailureWithWarning' => array(
                'okay' => false,
                'log' => true
            ),
        );


        if($ackCodes[ $result['responseEnvelope']['ack'] ]['log']) {
            // log the stuff so that you can contact PayPal Developer Tech Support
            if($weAreLoggingStuff)
                error_log('PayPal:'.$result['responseEnvelope']['build'].':'.$result['responseEnvelope']['correlationId'].':'.$result['responseEnvelope']['timestamp']);
        }

        if($ackCodes[ $result['responseEnvelope']['ack'] ]['okay']) {
            return $result;
        } else {
            debug($result);
            return FALSE;
        }

    }
    
}
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
    // CakePHP HttpSocket object
    private $httpSocket = null;
    public $config = array(
        'endpoint' => 'https://svcs.sandbox.paypal.com',
        'api_username' => '',
        'api_password' => '',
        'api_signature' => '',
        'app_id' => '',
        'scope' => array('ACCOUNT_BALANCE')
    );

    public function __construct($config = array()) {
        parent::__construct($config);
        $this->config = array_merge($this->config, $config);
        $this->httpSocket = new HttpSocket();
    }

    /**
     *
     * @param string $callbackPath
     */
    public function requestPermissions($returnUrl = '') {
        $query = array(
            'scope' => $this->config['scope'],
            'callback' => 'http://' . $_SERVER['SERVER_NAME'] . $returnUrl
        );
        $result = $this->_sendRequest('/Permissions/RequestPermissions', $query);
        if($this->ackHandler($result)) {
            $this->Cookie->write('ZuhaPaypalToken', $result['token'], false, 900);
            $this->redirect('https://www.paypal.com/cgi-bin/webscr?cmd=_grant-permission&request_token='.$result['token']);
        } else {
            return FALSE;
        }
    }

    public function getAccessToken($verificationCode) {

        $query = array(
            'token' => $this->Cookie->read('ZuhaPaypalToken'),
            'verifier' => $verificationCode
        );
        $result = $this->_sendRequest('/Permissions/GetAccessToken', $query);
        if($this->ackHandler($result)) {
            $return = array(
                'token' => $result['token'],
                'tokenSecret' => $result['tokenSecret']
            );
            return $return;
        } else {
            return FALSE;
        }

    }

     /**
     * A probably reusable Pass/Fail response parser with error/warning logging capability
     * @param array $result
     * @return boolean
     */
    private function ackHandler($result) {
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
            return TRUE;
        } else {
            debug($result);
            return FALSE;
        }

    }

    /**
     * This is our base request sender.  All requests funnel through here.
     * @param string $apiOperation
     * @param type $request
     * @return array
     */
    private function _sendRequest($apiOperation, $query) {

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
        $results = $this->httpSocket->get($this->config['endpoint'].$apiOperation, $query, $request);
	return json_decode($results);
    }

}
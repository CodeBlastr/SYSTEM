<?PHP

class PaypalModel extends Model {
    
    public function checkAccountLinkage($userId) {
        $user = $this->User->find(array(
            'conditions' => array('User.id' => $userId),
            'fields' => 'User.paypal_id'
            ));
        
        if($user['User']['paypal_id']) {
            return $user['User']['paypal_id'];
        } else {
            return FALSE;
        }
    }
    
    /**
     *
     * @param string $callbackPath
     */
    public function requestPermissions($returnUrl = '') {
        $query = array(
            'scope' => $this->config['scope'],
            //'callback' => 'http://' . $_SERVER['SERVER_NAME'] . $returnUrl
            'callback' => $this->referer()
        );
        $result = $this->Paypal->sendRequest('/Permissions/RequestPermissions', $query);
        if($result) {
            return $result;
        } else {
            return FALSE;
        }
    }

    /**
     * 
     * @param type $verificationCode
     * @return boolean
     */
    public function getAccessToken($verificationCode) {

        $query = array(
            'token' => $this->Cookie->read('ZuhaPaypalToken'),
            'verifier' => $verificationCode
        );
        $result = $this->Paypal->sendRequest('/Permissions/GetAccessToken', $query);
        if($result) {
//            $return = array(
//                'token' => $result['token'],
//                'tokenSecret' => $result['tokenSecret']
//            );
            return $result;
        } else {
            return FALSE;
        }

    }

    public function getBalance($param) {
        
    }

    
    public function createAccount($data) {
        
        $query = array(
            'accountType' => 'PERSONAL',
            'name' => array(
                'firstName' => $data['User']['firstName'],
                'lastName' => $data['User']['lastName'],
            ),
            'address' => array(
                'line1' => xxx,
                'line2' => xxx,
                'city' => xxx,
                'state' => xx,
                'postalCode' => xxxxx,
                'countryCode' => xxx,
            ),
            'citizenshipCountryCode' => xx,
            'contactPhoneNumber' => 'xxx-xxx-xxxx',
            'dateOfBirth' => 'YYYY-MM-DD'.'Z',
            'createAccountWebOptions' => array(
                'returnUrl' => '', //where the user is redirected after completing the PayPal account setup
            ),
            'currencyCode' => 'USD',
            'emailAddress' => xxx,
            'preferredLanguageCode' => 'en_US',
            'registrationType' => 'Web'
        );
        
        if(strstr($this->config['endpoint'], 'sandbox'))
                $query['sandboxEmailAddress'] = 'paypal-sandboxer@razorit.com';
        
        $result = $this->Paypal->sendRequest('/AdaptiveAccounts/CreateAccount', $query);
        if($result) {
            
            return $result;

        } else {
            return FALSE;
        }
    }
    
}
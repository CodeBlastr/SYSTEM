<?PHP
/**
 * 
 */
class PaypalController extends Controller {
    public $uses = 'Paypal';
    
    public function requestPermissions() {
        //$Paypal->requestPermissions('/tasks/tasks/my/');
        $success = $Paypal->requestPermissions();
        if($success) {
            $this->Cookie->write('ZuhaPaypalToken', $success['token'], false, 900);
            $this->redirect('https://www.paypal.com/cgi-bin/webscr?cmd=_grant-permission&request_token='.$success['token']);
            exit();
        }
    }
    
    public function createAcccount() {
        if($this->data) {
            $success = $Paypal->createAccount($this->data);
            if($success) {
                $this->Cookie->write('ZuhaPaypalToken', $result['token'], false, 900);
                $this->redirect($success['returnUrl']);
                exit();
            }
        }
    }
}
<?PHP
/**
 * 
 */
class PaypalController extends Controller {
    public $uses = 'Paypal';
    
    public function requestPermissions() {
        $Paypal->get_permission('/tasks/tasks/my/');
    }
}
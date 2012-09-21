<?PHP

class PaypalModel extends Model {
    
    public function checkAccountLinkage($userId) {
        $user = $this->User->find(array(
            'conditions' => array('User.id' => $userId),
            'fields' => 'User.paypal_id'
            ));
        
        if($user['User']['paypal_id']) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
}
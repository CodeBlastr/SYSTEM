<?php
/**
 * Form Security Component
 */
 
class FormSecurityComponent extends Component {
    
    public $Controller = null;
    
    // public function initialize(Controller $Controller) {
    	// return $Controller;
    // }
	
/**
 * Var defaults
 * 
 * An array of actions this component is allowed to edit the viewVars for.
 */
	public $defaults = array();
	
/**
 * Start up method
 */
    public function startup(Controller $Controller) {
    	if ($Controller->request->is('put') || $Controller->request->is('post')) {
    		if (defined('__APP_SECURE_FORMS')) {
				$thisAction = 'c' . Security::hash($Controller->request->here, 'md5', Configure::read('Security.salt'));
    			$secureForms = unserialize(__APP_SECURE_FORMS); // list of form actions that need to be secured
    			if (in_array($thisAction, $secureForms['form'])) {
    				// we're in an action that needs a key 
    				if (empty($Controller->request->data['FormKey']['id'])) {
    					// temp comment out // throw new Exception('you need a handshake');
    				}
					// temp comment out // $FormKey = ClassRegistry::init('Forms.FormKey');
					// temp comment out // $FormKey->testKey($Controller->request->data);
    			}
    		}
    	}
    }
    
    // public function beforeRender(Controller $Controller) {
    	// // The beforeRender method is called after the controller executes the requested action’s logic but before the controller’s renders views and layout.
    // }
//     
    // public function shutdown(Controller $Controller) {
    	// // The shutdown method is called before output is sent to browser.
    // }
	
}
<?php
/**
 * Payment Using User Credits
 */
//App::import('model' , 'Users.User');
class CreditComponent extends Object{
	var $name = 'Credit';
	var $controller = null;
	//var $uses = array('Users.User');
	var $components = array('Auth');
	
	function startup(&$controller) {
		if (!$this->controller) {
			$this->controller = $controller;
		}
	}	
	function initialize(&$controller) {
		if (!$this->controller) {
			$this->controller = $controller;
		}
	}
	
	function Pay($data){
		$user_id = AuthComponent::user('id');		
		$userObject = ClassRegistry::init('User');
		$creditData = $userObject->find('first' , array('conditions' => 
				array('User.credit_total >=' => $data['Order']['theTotal'],
						'User.id' => $user_id
				)));
				
		#if setting defined then multiply it by order Amount		
		if(defined('__USERS_CREDITS_PER_PRICE_UNIT')) :
			$credits = $data['Order']['theTotal'] * __USERS_CREDITS_PER_PRICE_UNIT ;
		endif;
		
		if(!empty($creditData) && intval($creditData['User']['credit_total']) >= intval($credits)) {
			$creditData['User']['credit_total'] = (intval($creditData['User']['credit_total']) - intval($credits));  
			$userObject->updateAll( array("User.credit_total" => $creditData['User']['credit_total']), 
									array( "User.id" => $user_id
								 ));
			$response['transaction_id'] = $userObject->__uuid('ot');
			$response['response_code'] = 1;
			$response['amount'] = $data['Order']['theTotal'];
			$this->_parseCreditResponse($response);
		}	
		else {
			$response['response_code'] = 0;
			$response['amount'] = $data['Order']['theTotal'];
			$this->_parseCreditResponse($response);
		}
		
	}
	
/**
 * Parse the response from Paypal into a more readable array
 * makes doing validation changes easier.
 *
 */
	function _parseCreditResponse($response) {
		if($response['response_code']) {
				$parsedResponse['reason_code'] = 1;
				$parsedResponse['response_code'] = 1;
				$parsedResponse['transaction_id'] = $response['transaction_id'];
				$parsedResponse['reason_text'] = 'Successful Payment';
				$parsedResponse['description'] = 'Transaction Completed';
		} else {
				$parsedResponse['response_code'] = 3; // similar to authorize
				$parsedResponse['reason_text'] = 'Not enough credits.';
				$parsedResponse['description'] = 'Please purchase credits separately.';
			}
		$parsedResponse['amount'] = $response['amount'];
		$this->response = $parsedResponse;
		
	}
	
}
?>
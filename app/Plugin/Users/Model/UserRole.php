<?php
App::uses('UsersAppModel', 'Users.Model');

class UserRole extends UsersAppModel {

	public $name = 'UserRole';
	public $actsAs = array('Acl' => array('requester'), 'Tree');
	public $viewPrefixes = array('admin' => 'admin');

	public $hasMany = array(
		'User' => array(
			'className' => 'Users.User',
			'foreignKey' => 'user_role_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

/**
 * 
 * @param boolean $created
 */
	public function afterSave($created) {
		$this->updateUserRolesViewPrefix();
	}

/**
 * updates users view_prefix if its been changed
 */
	public function updateUserRolesViewPrefix() {
		if (!empty($this->request->data['UserRole']['id'])) {
			$this->User->updateAll(
					array('User.view_prefix' => "'" . $this->request->data['UserRole']['view_prefix'] . "'"),
					array('User.user_role_id' => $this->request->data['UserRole']['id'])
			);
		}
	}
	
	
/**
 * This trims an object, formats it's values if you need to, and returns the data to be merged with the Transaction data.
 * 
 * @param string $key
 * @return array The necessary fields to add a Transaction Item
 */
	public function mapTransactionItem($key) {
	    
	    $itemData = $this->find('first', array('conditions' => array('id' => $key)));
	    
	    $fieldsToCopyDirectly = array(
    		'name'
	        );
	    
	    foreach($itemData['UserRole'] as $k => $v) {
    		if(in_array($k, $fieldsToCopyDirectly)) {
    		    $return['TransactionItem'][$k] = $v;
    		}
	    }
	    return $return;
	}
	
	
/**
 * 
 * @param array $data A payment object
 */
	public function afterSuccessfulPayment($data) {
//		debug( $data );
//		break;
		foreach ( $data['TransactionItem'] as $transactionItem ) {
			if ( $transactionItem['model'] == 'UserRole' ) {
				$this->User->changeRole(array(
					'User' => array(
						'id' => $data['Customer']['id'],
						'user_role' => $transactionItem['foreign_key']
					)
				));
			}
		}
	}

/**
 * This is to be triggered by another Model's afterSave()
 * i.e. We can trigger an action here after we save a Transaction
 */
	public function origin_afterSave() {
		
	}

/**
 * 
 * @return array
 */
	public function viewPrefixes() {
		return array(
			'admin' => 'admin',
		);
	}

/**
 * Parent Node is now null according to: 
 * http://book.cakephp.org/2.0/en/tutorials-and-examples/simple-acl-controlled-application/simple-acl-controlled-application.html?highlight=acl%20both
 * 
 * @return null
 */
	public function parentNode() {
		return null;
	}
	
}

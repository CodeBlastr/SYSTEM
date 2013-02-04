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

<?php
App::uses('UsersAppModel', 'Users.Model');

class UserConnect extends UsersAppModel {

	public $name = 'UserConnect';
	
	public $hasOne = array(
		'User' => array(
			'className' => 'Users.User',
			'foreignKey' => 'user_id',
			'dependent' => false,
		)
	);
	
/** 
 * Uses session vars from a 3rd party authentication to create a relationship
 * between a user id here, and a user id on the 3rd party site.
 * 
 * @return bool
 */
	public function add($data) {
		$data['UserConnect']['user_id'] = CakeSession::read('Auth.User.id');
		if ($this->save($data)) {
			return true;
		} else {
			throw new Exception(__('Connection to app failed'));
		}
	}
}
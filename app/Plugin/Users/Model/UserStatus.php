<?php
App::uses('UsersAppModel', 'Users.Model');

class UserStatus extends UsersAppModel {
	var $name = 'UserStatus';
	var $displayField = 'status';
	
	var $belongsTo = array(
		'User' => array(
			'className' => 'Users.User',
			'foreignKey' => 'creator_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
?>
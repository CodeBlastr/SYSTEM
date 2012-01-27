<?php
App::uses('UsersAppModel', 'Users.Model');

class UserWall extends UsersAppModel {
	var $name = 'UserWall';
	var $displayField = 'post';
	
	var $belongsTo = array(
		'Owner' => array(
			'className' => 'Users.User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Creator' => array(
			'className' => 'Users.User',
			'foreignKey' => 'creator_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	);
}
?>
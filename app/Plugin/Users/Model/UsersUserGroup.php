<?php
class UsersUserGroup extends UsersAppModel {
	var $name = 'UsersUserGroup';
	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $useTable = 'users_user_groups';
	
	var $belongsTo = array(
		'User' => array(
			'className' => 'Users.User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'UserGroup' => array(
			'className' => 'Users.UserGroup',
			'foreignKey' => 'user_group_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
?>
<?php
App::uses('UsersAppModel', 'Users.Model');

class UserGroupWallPost extends UsersAppModel {
	var $name = 'UserGroupWallPost';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'UserGroup' => array(
			'className' => 'Users.UserGroup',
			'foreignKey' => 'user_group_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Creator'=>array(
			'className' => 'Users.User',
			'foreignKey' => 'creator_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	var $hasMany = array(
		'Comment' => array(
			'className' => 'Comments.Comment',
			'foreignKey' => 'foreign_key',
			'conditions' => array('Comment.model' => 'UserGroupWallPost')
		)
	);
}

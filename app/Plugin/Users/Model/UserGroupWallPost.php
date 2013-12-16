<?php
App::uses('UsersAppModel', 'Users.Model');

class UserGroupWallPost extends UsersAppModel {
	public $name = 'UserGroupWallPost';

	public $actsAs = array('Comments.Commentable');
	
	public $belongsTo = array(
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
	
	public $hasMany = array(
		'Comment' => array(
			'className' => 'Comments.Comment',
			'foreignKey' => 'foreign_key',
			'conditions' => array('Comment.model' => 'UserGroupWallPost')
		)
	);
}

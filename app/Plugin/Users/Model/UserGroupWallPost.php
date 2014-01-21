<?php
App::uses('UsersAppModel', 'Users.Model');

class UserGroupWallPost extends UsersAppModel {
	
	public $name = 'UserGroupWallPost';
	
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

	public function __construct($id = false, $table = null, $ds = null) {
		if (CakePlugin::loaded('Comments')) {
			$this->actsAs[] = 'Comments.Commentable';
			$this->hasMany['Comment'] = array(
				'className' => 'Comments.Comment',
				'foreignKey' => 'foreign_key',
				'conditions' => array('Comment.model' => 'UserGroupWallPost')
			);
		}
		parent::__construct($id, $table, $ds);
	}
}

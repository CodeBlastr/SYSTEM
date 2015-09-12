<?php
App::uses('UsersAppModel', 'Users.Model');

class AppUserGroupWallPost extends UsersAppModel {
	
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
		if (CakePlugin::loaded('Categories')) {
			$this->actsAs[] = 'Categories.Categorizable';
		}
		
		if (CakePlugin::loaded('FileStorage')) {
			$this->actsAs[] = 'FileStorage.FileAttach';
		}
		parent::__construct($id, $table, $ds);
	}
}

if (!isset($refuseInit)) {
	class UserGroupWallPost extends AppUserGroupWallPost {}
}

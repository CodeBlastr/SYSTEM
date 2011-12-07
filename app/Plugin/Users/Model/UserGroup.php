<?php
class UserGroup extends UsersAppModel {
	var $name = 'UserGroup';
	var $displayField = 'title';
	
	#var $hasAndBelongsToMany = array(
    #    'User' =>
    #        array(
    #            'className'              => 'Users.User',
    #            'joinTable'              => 'users_user_groups',
    #            'foreignKey'             => 'user_group_id',
    #            'associationForeignKey'  => 'user_id'
    #        )
    #);
    
    var $belongsTo = array(
		'Creator' => array(
			'className' => 'Users.User',
			'foreignKey' => 'creator_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	var $hasMany = array(
		'User'=>array(
			'className'     => 'Users.User',
            'foreignKey'    => 'user_id'
		),
		'UsersUserGroup'=>array(
			'className'     => 'Users.UsersUserGroup',
            'foreignKey'    => 'user_group_id'
		),
		'UserGroupWallPost'=>array(
			'className'     => 'Users.UserGroupWallPost',
            'foreignKey'    => 'user_group_id'
		)
	);
	
	function findUserGroupsByModerator($moderatorId = null, $type = 'list', $params = array('order' => 'UserGroup.title')) {
		# you must be a moderator to see groups
		$params['joins'] = array(array(
			'table' => 'users_user_groups',
			'alias' => 'UsersUserGroup',
			'type' => 'INNER',
			'conditions' => array(
				'UsersUserGroup.user_id' => $moderatorId,
				'UsersUserGroup.is_moderator' => 1,
				),
			));
		return $this->find($type, $params);
	}
	
	function findRelated($model = null, $type = 'list', $params = array('order' => 'UserGroup.title')) {
		# groups can be assigned to only certain other systems by associating a model to the group
		$params['conditions']['UserGroup.model'] = $model;
		return $this->find($type, $params);
	}
}
?>
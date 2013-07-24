<?php
App::uses('UsersAppModel', 'Users.Model');

class UserGroup extends UsersAppModel {
	public $name = 'UserGroup';
	public $displayField = 'title';
	
	public $hasAndBelongsToMany = array(
        'User' => array(
			'className' => 'Users.User',
            'joinTable' => 'users_user_groups',
			'foreignKey' => 'user_group_id',
			'associationForeignKey' => 'user_id'
			),
		);
    
    public $belongsTo = array(
		'Creator' => array(
			'className' => 'Users.User',
			'foreignKey' => 'creator_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
			),
		);
	
	public $hasMany = array(
		'UsersUserGroup'=>array(
			'className'     => 'Users.UsersUserGroup',
            'foreignKey'    => 'user_group_id'
		),
		'UserGroupWallPost'=>array(
			'className'     => 'Users.UserGroupWallPost',
            'foreignKey'    => 'user_group_id'
		)
	);
	
	public function findUserGroupsByModerator($type = 'list', $params = array('order' => 'UserGroup.title')) {
		# you must be a moderator to see groups
		$userRoleId = CakeSession::read('Auth.User.user_role_id');
		if ($userRoleId != 1) {
			$userId = CakeSession::read('Auth.User.id');
			$params['joins'] = array(array(
				'table' => 'users_user_groups',
				'alias' => 'UsersUserGroup',
				'type' => 'INNER',
				'conditions' => array(
					'UsersUserGroup.user_id' => $userId,
					'UsersUserGroup.is_moderator' => 1,
					),
				));
		}
		return $this->find($type, $params);
	}
	
	public function findUserGroupStatus($type = 'first', $params = null) {
		# you must be a moderator to see groups
		$userRoleId = CakeSession::read('Auth.User.user_role_id');
		if ($userRoleId == 1) {
			$status = 'moderator';
		} else {
			$params['conditions']['UsersUserGroup.user_id'] = CakeSession::read('Auth.User.id');
			$usersUserGroup = $this->UsersUserGroup->find($type, $params);
			if ($usersUserGroup['UsersUserGroup']['is_moderator'] == 1) {
				$status = 'moderator';
			} else if ($usersUserGroup['UsersUserGroup']['is_approved'] == 1) {
				$status = 'approved';
			} else if (!empty($usersUserGroup['UsersUserGroup'])) {
				$status = 'pending';
			} else {
				$status = null;
			}
		}
		return $status;
	}
	
	public function findRelated($model = null, $type = 'list', $params = array('order' => 'UserGroup.title')) {
		# groups can be assigned to only be available to certain other systems by associating a model to the group
		$params['conditions']['UserGroup.model'] = $model;
		return $this->find($type, $params);
	}
	
/**
 * User method
 * 
 * Create a user and add to the provided group id
 * 
 * @param array $data
 */
	public function user($data) {
		$randompassword = substr(str_shuffle('abcdefghijklmnopqrstuvwxyz'),0,3);
		$randompassword .= substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'),0,3);
		$randompassword .= substr(str_shuffle('0123456789'),0,3);
		$randompassword = substr(str_shuffle($randompassword),0,8);
		$data['User']['password'] = $randompassword;
		$data['User']['confirm_password'] = $randompassword;
		$data['User']['pwd_change'] = 1;
		if ($this->User->saveAll($data)) {
			$site = defined('SITE_NAME') ? SITE_NAME : 'New';
			$url = 'http://' . $_SERVER['HTTP_HOST'] . '/users/users/login';
			$message = __('You have a new user account. <br /><br /> username : %s<br />password : %s <br /><br />Please <a href="%s">login</a> and change your password immediately.  <br /><br /> If the link above is not usable please copy and paste the following into your browser address bar : %s', $data['User']['username'], $data['User']['password'], $url, $url);
			$this->__sendMail($data['User']['username'], __('%s User Account Created', $site), $message);
			return true;
		}
	}
}
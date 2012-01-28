<?php
App::uses('UsersAppModel', 'Users.Model');

class UsersUserGroup extends UsersAppModel {
	public $name = 'UsersUserGroup';
	//The Associations below have been created with all possible keys, those that are not needed can be removed
	public $useTable = 'users_user_groups';
	
	public $belongsTo = array(
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
	
	public function add($data) {
		$groupId = $this->_groupId($data);
		$userId =  $this->_userId($data);
		$approved =  $this->_isApproved($data);
		$moderator =  $this->_isModerator($data);
		# check if user is already in this grpoup or not
		$userCount = $this->find('count' , array(
			'conditions'=>array(
				'user_group_id' => $groupId,
				'user_id' => $userId
				),
			'contain'=>array()
		));
		
		if($userCount == 0) {
			$data = array(
				'UsersUserGroup' => array(
					'user_group_id' => $groupId,
					'user_id' => $userId,
					'is_approved' => $approved,
					'is_moderator' => $moderator,
					),
				);
			if ($this->save($data)) {
				return true;
			} else {
				throw new Exception(__d('users', 'User could not be added to group.'));
			}				
		} else {
			throw new Exception(__d('users', 'User is already in this group.'));
		}
	}
	
	private function _isApproved($data) {
		# incoming data from UsersUserGroupController
		if (!empty($data['UsersUserGroup']['is_approved'])) {
			return 1;
		}
		return 0;
	}
	
	private function _isModerator($data) {
		# incoming data from UsersUserGroupController
		if (!empty($data['UsersUserGroup']['is_moderator'])) {
			return 1;
		}
		return 0;
	}
	
	private function _groupId($data) {
		# incoming data from the UserModel
		if (!empty($data['UserGroup']['UserGroup']['id'])) {
			return $data['UserGroup']['UserGroup']['id'];
		}
		# incoming data from UsersUserGroupController
		if (!empty($data['UsersUserGroup']['user_group_id'])) {
			return $data['UsersUserGroup']['user_group_id'];
		}
		return;
	}
	
	
	private function _userId($data) {
		# incoming data from the UserModel
		if (!empty($this->User->id)) {
			return $this->User->id;
		}
		# incoming data from the UserModel
		if (!empty($data['User']['id'])) {
			return $data['User']['id'];
		}
		# incoming data from UsersUserGroupController
		if (!empty($data['UsersUserGroup']['user_id'])) {
			return $data['UsersUserGroup']['user_id'];
		}
		return CakeSession::read('Auth.User.id');
	}
		
}
?>
<?php
App::uses('UsersAppModel', 'Users.Model');

/**
 * Extension Code
 * $refuseInit = true; require_once(ROOT.DS.'app'.DS.'Plugin'.DS.'Users'.DS.'Model'.DS.'UsersUserGroup.php');
 * @property User User
 */
class AppUsersUserGroup extends UsersAppModel {
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
			),
		'Moderator' => array(
			'className' => 'Users.User',
			'foreignKey' => 'user_id',
			'conditions' => array('UsersUserGroup.is_moderator' => true),
			'dependent' => false
			)
		);

	/**
	 * Add method
	 *
	 */
	public function add($data) {
		$groupId = $this->_groupId($data);
		$userId = $this->_userId($data);
		$approved = $this->_isApproved($data);
		$moderator = $this->_isModerator($data);
		// check if user is already in this group
		$userCount = $this->find('count', array('conditions' => array('user_group_id' => $groupId, 'user_id' => $userId, ), 'contain' => array()));
		// check if user is already in this group AND NOT approved (eg. a pending request)
		$user = $this->find('first', array('conditions' => array('user_group_id' => $groupId, 'user_id' => $userId, 'is_approved' => 0), 'contain' => array()));
		if ($userCount == 0) {
			$data = array('UsersUserGroup' => array('user_group_id' => $groupId, 'user_id' => $userId, 'is_approved' => $approved, 'is_moderator' => $moderator, ), );
			if ($this->save($data)) {
				return true;
			} else {
				throw new Exception(__d('users', 'User could not be added to group.'));
			}
		} else if (!empty($user)) {
			// user is pending get the id so we don't create duplicate records
			$data = array('UsersUserGroup' => array('id' => $user['UsersUserGroup']['id'], 'user_group_id' => $groupId, 'user_id' => $userId, 'is_approved' => $approved, 'is_moderator' => $moderator, ), );
			if ($this->save($data)) {
				return true;
			} else {
				throw new Exception(__d('users', 'User could not be approved.'));
			}
		} else {
			CakeSession::delete('afterUserCreated');
			CakeSession::delete('afterUserLogin');
			throw new Exception(__d('users', 'User is already in this group.'));
		}
	}

	/**
	 * @param integer $userId | default null, if not passed use current logged in user's id
	 * @param string $type
	 * @param array $options
	 *
	 * @return array
	 */
	public function getUserGroups($userId = null, $type = 'all', $options = array()) {
		$conditions = array('UsersUserGroup.user_id' => !is_null($userId) ? $userId : $this->_userId());
		// was this, but sure seems like it shouldn't be moderator only groups by default
		// $conditions = array('UsersUserGroup.user_id' => !is_null($userId) ? $userId : $this->_userId(), 'UsersUserGroup.is_moderator' => 1);
		if (!empty($options)) {
			if (isset($options['owner'])) {
				$conditions['UsersUserGroup.is_moderator'] = $options['owner'] === true ? 1 : 0;
			}
		}
		$userGroups = $this->User->UserGroup->UsersUserGroup->find($type, array('conditions' => $conditions, 'contain' => array('UserGroup')));
		return $userGroups;
	}

	public function getIntersectUserGroups($userId, $viewUserId) {
		$userGroups = Set::combine($this->getUserGroups($userId, 'all', array('owner' => false)), '{n}.UserGroup.id', '{n}.UserGroup.title');

		$viewUserGroup = Set::combine($this->getUserGroups($viewUserId, 'all', array('owner' => true)), '{n}.UserGroup.id', '{n}.UserGroup.title');

		return array_intersect($userGroups, $viewUserGroup);
	}

	private function _isApproved($data) {
		// incoming data from UsersUserGroupController
		if (!empty($data['UsersUserGroup']['is_approved'])) {
			return 1;
		}
		return 0;
	}

	private function _isModerator($data) {
		// incoming data from UsersUserGroupController
		if (!empty($data['UsersUserGroup']['is_moderator'])) {
			return 1;
		}
		return 0;
	}

	private function _groupId($data) {
		// incoming data from the UserModel
		if (!empty($data['UserGroup']['UserGroup']['id'])) {
			return $data['UserGroup']['UserGroup']['id'];
		}
		// incoming data from UsersUserGroupController
		if (!empty($data['UsersUserGroup']['user_group_id'])) {
			return $data['UsersUserGroup']['user_group_id'];
		}
		return;
	}

	private function _userId($data = array()) {
		// incoming data from the UserModel
		if (!empty($this->User->id)) {
			return $this->User->id;
		}
		// incoming data from the UserModel
		if (!empty($data['User']['id'])) {
			return $data['User']['id'];
		}
		// incoming data from UsersUserGroupController
		if (!empty($data['UsersUserGroup']['user_id'])) {
			return $data['UsersUserGroup']['user_id'];
		}
		return CakeSession::read('Auth.User.id');
	}

}

if (!isset($refuseInit)) {
	class UsersUserGroup extends AppUsersUserGroup {
	}

}

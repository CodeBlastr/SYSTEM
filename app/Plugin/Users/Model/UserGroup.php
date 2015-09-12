<?php
App::uses('UsersAppModel', 'Users.Model');

/**
 * Extension Code
 * $refuseInit = true; require_once(ROOT.DS.'app'.DS.'Plugin'.DS.'Users'.DS.'Model'.DS.'UserGroup.php');
 * @property UsersUserGroup UsersUserGroup
 * @property User User
 */
class AppUserGroup extends UsersAppModel {

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
            'foreignKey'    => 'user_group_id',
			'dependent'		=> true
		),
		'UserGroupWallPost'=>array(
			'className'     => 'Users.UserGroupWallPost',
            'foreignKey'    => 'user_group_id',
			'dependent'		=> true
		)
	);

	public function beforeSave($options = array()) {
		if (!empty($this->data[$this->alias]['password'])) {
			App::uses('AuthComponent', 'Controller/Component');
	        $this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
		}
		parent::beforeSave($options);
	}


	/**
 *
 * @param string $type
 * @param array $params
 * @return array Array of records, or Null on failure.
 */
	public function findUserGroupsByModerator($type = 'list', $params = array('order' => 'UserGroup.title')) {
		// you must be a moderator to see groups
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

/**
 *
 * @param string $type
 * @param array $params
 * @return string|null
 */
	public function findUserGroupStatus($type = 'first', $params = null) {
		// you must be a moderator to see groups
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

/**
 *
 * @param string $model
 * @param string $type
 * @param array $params
 * @return array Array of records, or Null on failure.
 */
	public function findRelated($model = null, $type = 'list', $params = array('order' => 'UserGroup.title')) {
		// groups can be assigned to only be available to certain other systems by associating a model to the group
		$params['conditions']['UserGroup.model'] = $model;
		return $this->find($type, $params);
	}

/**
 *
 * @param int $pendingId
 * @param int $groupId
 * @param int $userId
 */
	public function approve($pendingId, $groupId, $userId){
		if(!empty($pendingId) && !empty($groupId) && !empty($userId)){
			$isMyGroup = $this->isMyGroup($groupId,$userId);
			if($isMyGroup){
				$row = $this->UsersUserGroup->read(null,$pendingId);

				if($row['UsersUserGroup']['user_group_id'] === $groupId){
					$row['UsersUserGroup']['is_approved'] = 1;
					$this->UsersUserGroup->save($row);
				}
			}

		}
	}

/**
 *
 * @param int $pendingId
 * @param int $groupId
 * @param int $userId
 */
	public function isApproved($groupId, $userId){
		if(!empty($groupId) && !empty($userId)) {
			if ($this->UsersUserGroup->find('count', array('conditions' => array('UsersUserGroup.is_approved' => 1, 'UsersUserGroup.user_group_id' => $groupId, 'UsersUserGroup.user_id' => $userId)))) {
				return true;
			};
		}
		return false;
	}

/**
 *
 * @param int $id
 * @param int $userId
 * @return boolean
 */
	public function isMyGroup($id, $userId){
		return $this->find('count', array(
			'fields'=>array('Creator.id'),
			'conditions'=>array('UserGroup.id'=>$id,'Creator.id'=>$userId),
			'contain'=>array('Creator')))
			===1;
	}

/**
 * User method
 *
 * Create a user and add to the provided group id
 *
 * @param array $data
 * @return boolean
 */
	public function user($data) {
        $this->User->autoLogin = false;
		return $this->User->procreate($data);
	}

/**
 * Used as a callback from the Invite Model, and automatically adds the invited user to the group.
 * Must return true if it worked.
 *
 * @param array $invite
 * @return boolean
 * @throws Exception
 */
 	public function processInvite($inviteId = null, $userId = null) {
 		// $inviteId used to be $invite and include the entire invite record (not needed, just using the inviteId is better)
 		if (is_array($inviteId)) {
 			$userGroupId = $inviteId['Invite']['foreign_key']; // backwards compatibility
 		} else {
 			$Invite = ClassRegistry::init('Invites.Invite');
			$Invite->id = $inviteId;
			$userGroupId = $Invite->field('foreign_key');
 		}
		
 		$userGroup = $this->find('first', array('conditions' => array('UserGroup.id' => $userGroupId)));
		if (!empty($userGroup)) {
			$data['UsersUserGroup']['user_id'] = !empty($userId) ? $userId : CakeSession::read('Auth.User.id'); // backwards compatibility
			$data['UsersUserGroup']['user_group_id'] = $userGroupId;
			$data['UsersUserGroup']['is_approved'] = 1;
			if ($this->UsersUserGroup->add($data)) {
				// update the invite status to accepted
				return $Invite->_updateStatus($inviteId, 1, $data['UsersUserGroup']['user_id']);
			} else {
				throw new Exception(__('Auto add to user group failed.'));
			}
		} else {
			throw new Exception(__('Group does not exist.'));
		}
 	}
}

if (!isset($refuseInit)) {
	class UserGroup extends AppUserGroup {}
}
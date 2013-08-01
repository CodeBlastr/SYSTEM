<?php
/**
 *	This Behavior will automatically create & relate a UserGroup to any Model
 *
 *  This Behavior manages two Models.
 *	1) A "main model" / the belongsTo model - the model whose creation will also create a user group
 *	2) A "group members model" / the hasMany model - the model that represents the members of the main model
 *
 *	@todo This needs to use the User.id of the User that is being added to the thing.. not the User.Id of the current logged in User
 */
app::uses('UserGroup', 'Users.Model');
class UserGroupableBehavior extends ModelBehavior {

	public $settings = array();
	public $foreignKeyToDeleteFrom = null;

/**
 *
 * @param Model $Model
 * @param array $settings
 */
	public function setup(Model $Model, $settings = array()) {
		// settings go here
		$this->settings[$Model->alias] = $settings;

		if ( isset($this->settings[$Model->alias]['hasMany']) ) {
			// our main $Model hasOne UserGroup
			$Model->bindModel(
				array('hasOne' => array(
					'UserGroup' => array(
						'className' => 'Users.UserGroup',
						'foreignKey' => 'foreign_key',
						'conditions' => array('UserGroup.model' => $Model->alias),
						'dependent' => true
					)
				)), false
			);
		}

	}

/**
 * 
 *
 * @param Model $Model
 * @param boolean $created
 */
	public function afterSave(Model $Model, $created) {
		if ( isset($this->settings[$Model->alias]['hasMany']) ) {
			$this->_mainModelAfterSave($Model, $created);
		} else {
			$this->_groupMembersModelAfterSave($Model, $created);
		}
	}

	public function beforeDelete(Model $Model, $cascade = true) {
		if ( isset($this->settings[$Model->alias]['hasMany']) ) {
			$this->_mainModelBeforeDelete($Model);
		} else {
			$this->_groupMembersModelBeforeDelete($Model);
		}
	}
	public function afterDelete(Model $Model) {
		if ( isset($this->settings[$Model->alias]['hasMany']) ) {
			$this->_mainModelAfterDelete($Model);
		} else {
			$this->_groupMembersModelAfterDelete($Model);
		}
	}

/**
 * We're going to create a UserGroup when a new Model record is created
 *
 * @param Model $Model
 * @param boolean $created
 */
	private function _mainModelAfterSave(Model $Model, $created) {
		if ( $created ) {
			$UserGroup = new UserGroup;
			// create a UserGroup for this Course
			$data = $UserGroup->create(array(
				'title' => $Model->data[$Model->alias][$Model->displayField],
				'model' => $Model->alias,
				'foreign_key' => $Model->id,
				'owner_id' => $Model->userId
			));
			$UserGroup->save($data);
			// make the current Auth.User a member, and the moderator, for this group
			$UserGroup->UsersUserGroup->add(array(
				'UsersUserGroup' => array(
					'user_id' => $Model->userId,
					'user_group_id' => $UserGroup->id,
					'is_moderator' => 1,
					'is_approved' => 1
				)
			));
		}
	}


/**
 * Adds a user to a User Group after they have been related to the Main Model
 * @param Model $Model
 * @param boolean $created
 */
	private function _groupMembersModelAfterSave(Model $Model, $created) {
		if ( $created ) {
			$UserGroup = new UserGroup;
			// find the UserGroup for the Model that this User was just attached to
			$userGroupId = $UserGroup->find('first', array(
				'conditions' => array(
					'UserGroup.model' => $this->settings[$Model->alias]['belongsTo'],
					'UserGroup.foreign_key' => $Model->data[ $Model->alias ][ $Model->belongsTo[$this->settings[$Model->alias]['belongsTo']]['foreignKey'] ]
				),
				'fields' => array('id')
			));
			$userGroupId = $userGroupId['UserGroup']['id'];

			try {
				// add our user to this group
				$UserGroup->UsersUserGroup->create();
				$UserGroup->UsersUserGroup->add(array(
					'UsersUserGroup' => array(
						'user_id' => $Model->userId,
						'user_group_id' => $userGroupId,
						'is_approved' => 1
					)
				));
			} catch (Exception $e) {
				debug($e->getMessage());
				break;
			}
			
		}
	}

	private function _mainModelBeforeDelete(Model $Model, $cascade = true) {
		return true;
	}

	private function _mainModelAfterDelete(Model $Model) {
		$UserGroup = new UserGroup;
		// find the UserGroup for the Model that this User was just removed from
		$userGroupId = $UserGroup->find('first', array(
			'conditions' => array(
				'UserGroup.model' => $Model->alias,
				'UserGroup.foreign_key' => $Model->id
			),
			'fields' => array('id')
		));
		// delete this UserGroup
		$UserGroup->delete($userGroupId['UserGroup']['id']);
		// the UserGroup's members and wallPosts will be deleted through cascading
	}

	private function _groupMembersModelBeforeDelete(Model $Model, $cascade = true) {
		// before a Group Member gets deleted from the hasMany, we need.. stuff.
		$foreignModel = $this->settings[$Model->alias]['belongsTo'];
		$foreignKey = $Model->belongsTo[$foreignModel]['foreignKey'];
		$foreignKeyValue = $Model->find('first', array(
			'conditions' => array('id' => $Model->id),
		));
		$this->foreignKeyToDeleteFrom = $foreignKeyValue[$Model->alias][$foreignKey];
		return true;
	}

	private function _groupMembersModelAfterDelete(Model $Model) {
		$UserGroup = new UserGroup;
		// find the UserGroup for the Model that this User was just removed from
		$userGroupId = $UserGroup->find('first', array(
			'conditions' => array(
				'UserGroup.model' => $this->settings[$Model->alias]['belongsTo'],
				'UserGroup.foreign_key' => $this->foreignKeyToDeleteFrom
			),
			'fields' => array('id')
		));
		// remove them from the group
		$UserGroup->UsersUserGroup->deleteAll(array(
			'user_id' => $Model->userId,
			'user_group_id' => $userGroupId['UserGroup']['id']
		));
		#debug($userGroupId);break;
	}


//	public function removeUserFromUserGroup($data) {
//		$UserGroup = new UserGroup;
//		$UserGroup->UsersUserGroup->deleteAll(array(
//			'conditions' => array(
//				'user_id' => $data['UserGroup']['user_id'],
//				'model' => $data['UserGroup']['model'],
//				'foreign_key' => $data['UserGroup']['foreign_key']
//			)
//		));
//	}

}

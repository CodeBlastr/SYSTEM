<?php
class UsableBehavior extends ModelBehavior {

	var $model = '';
	var $foreignKey = '';
	var $defaultRole = '';
	var $userData = array();

	function setup(&$model, $settings = array()) {
		$this->defaultRole = !empty($settings['defaultRole']) ? $settings['defaultRole'] : null;
	}

	function beforeSave(&$model) {
		#remove habtm user data and give it to the afterSave() function
		if (!empty($model->data['User']['User'])) :
			$this->userData = $model->data;
			unset($model->data['User']['User']);
		endif;
		
		$model->data = $this->getChildContacts($model);
		
		return true;
	}
	/**
	 * Update the find methods so that we check against the used table that the current user is part of this item being searched.
	 * @todo	I'm sure we will need some checks and stuff added to this.  (Right now this Project is Used, so make sure Project works if you change this function.)
	 */
	function beforeFind(&$model, $queryData) {
		$userRole = CakeSession::read('Auth.User.user_role_id');
		$userId = CakeSession::read('Auth.User.id');
		//if ($userRole != 1) : 
			// temporary until we find a better way
			# this allows you to bypass the logged in user check (nocheck should equal the user id)
			$userQuery = !empty($queryData['nocheck']) ? "Used.user_id = {$queryData['nocheck']}" : "Used.user_id = {$userId}";
			# output the new query
			$queryData['joins'] = array(array(
				'table' => 'used',
				'alias' => 'Used',
				'type' => 'INNER',
				'conditions' => array(
				"Used.foreign_key = {$model->alias}.id",
				"Used.model = '{$model->alias}'",
				$userQuery,
				),
			));
		//endif;
		return $queryData;
	}
	
	/**
	 * Callback used to save related users, into the used table, with the proper relationship.
	 */
	function afterSave(&$Model, $created) {
		# get current users using, so that we can merge and keep duplicates out later
		$currentUsers = $this->findUsedUsers($Model, $foreignKey = $Model->data[$Model->alias]['id'], $type = 'all', array('fields' => 'id'));
		
		# this is if we have a hasMany list of users coming in.
		if (!empty($Model->data['User'][0])) :
			foreach ($Model->data['User'] as $user) :
				#$users[]['id'] = $user['user_id']; // before cakephp 2.0 upgrade
				$users[]['id'] = !empty($user['user_id']) ? $user['user_id'] : $user['id'];
			endforeach;
		endif;
		
		# this is if we have a habtm list of users coming in.
		if (!empty($this->userData['User']['User'][0])) :
			foreach ($this->userData['User']['User'] as $userId) :
				$users[]['id'] = $userId;
			endforeach;
		endif;
		
		# this is if its a user group we need to look up.
		if (!empty($Model->data[$Model->alias]['user_group_id'])) :
			# add all of the team members to the used table 
			$userGroups = $Model->UserGroup->find('all', array(
				'conditions' => array(
					'UserGroup.id' => $Model->data[$Model->alias]['user_group_id'],
					),
				'contain' => array(
					'User' => array(
						'fields' => 'User.id',
						),
					),
				));
			foreach ($userGroups as $userGroup) :
				if(!empty($userGroup['User'])) : 
					$users = !empty($users) ? array_merge($userGroup['User'], $users) : $userGroup['User'];
				endif;
			endforeach;
		endif;
		
		
		#gets rid of duplicate users from two arrays... @todo: maybe move this to its own function if its needed again
		$users = Set::extract('/id', $users);
		$currentUsers = Set::extract('/User/id', $currentUsers);
		$users = array_diff($users, $currentUsers);
		
		if (!empty($users)) :
			$i=0;
			foreach ($users as $user) : 
				$data[$i]['Used']['user_id'] = $user;
				$data[$i]['Used']['foreign_key'] = $Model->id;
				$data[$i]['Used']['model'] = $Model->alias;
				$data[$i]['Used']['role'] = $this->defaultRole; // this is temporary, until we start doing real acl 
				$i++;
			endforeach;
			
			$Used = ClassRegistry::init('Users.Used');
			foreach ($data as $dat) : 
				$Used->create();
				$Used->save($dat);
			endforeach;
		endif;
	}
	
	
	function findUsedObjects(&$model, $userId = null, $type = 'list', $params = array()) {
		$joins = array('joins' => array(array(
			'table' => 'used',
			'alias' => 'Used',
			'type' => 'INNER',
			'conditions' => array(
				"Used.user_id = {$userId}",
				"Used.model = '{$model->alias}'",
				"Used.foreign_key = {$model->alias}.id",
				),
			)));
		# note : Last changed this based on adding a user here : /projects/projects/people/{id}
		# make sure it still works there if changed.
		$params = !empty($params) ? array_merge($joins, $params) : $joins;
		# we can do a simple find with the model, because beforeFind of usable limits the results by user
		$results = $model->find($type, $params);
		if (!empty($results)) : 
			return $results;
		else : 
			return array();
		endif;
	}
	
	
	function findUsedUsers(&$model, $foreignKey = null, $type = 'list', $params = null) {
		$joins = array('joins' => array(array(
			'table' => 'used',
			'alias' => 'Used',
			'type' => 'INNER',
			'conditions' => array(
				"Used.foreign_key = '{$foreignKey}'",
				"Used.model = '{$model->alias}'",
				"Used.user_id = User.id",
				),
			)));
		$params = !empty($params) ? array_merge($joins, $params) : $joins;
		$results = $model->Used->User->find($type, $params);
		if (!empty($results)) : 
			return $results;
		else : 
			return array();
		endif;
	}
	
	/** 
	 * Add a used user to an object
	 */
	function addUsedUser(&$model, $data) {
		# do a check to see if the user is already a part of this object (we don't want duplicates)
		$objects = $this->findUsedObjects($model, $data['Used']['user_id'], 'all', array('conditions' => array('Used.foreign_key' => $data['Used']['foreign_key']), 'fields' => 'id'));
		$objectIds = Set::extract("/{$model->alias}/id", $objects);
		if (array_search($data['Used']['foreign_key'], $objectIds)) : 
			throw new Exception('User is already involved.');
		else : 
			if ($model->Used->saveAll($data)) : 
				return true;
			else : 
				throw new Exception('User add failed.');
			endif;
		endif;
	}
	
	
	/** 
	 * Remove used users from the object
	 */
	function removeUsedUser(&$model, $userId = null, $foreignKey = null) {
		if ($model->Used->deleteAll(array('Used.user_id' => $userId, 'Used.foreign_key' => $foreignKey))) : 
			return true;
		else : 
			return false;
		endif;
	}
	
	
	/**
	 * Find child contacts of a parent contact and add them to the data user list
	 */
	function getChildContacts(&$model) {
		if (!empty($model->data[$model->alias]['contact_id']) && $model->data[$model->alias]['contact_all_access']) : 
			# add all of the companies people to the used table
			# note, if the model has contact_id, then it should belongTo Contact
			$contacts = $model->Contact->Employer->find('first', array(
				'conditions' => array(
					'Employer.id' => $model->data[$model->alias]['contact_id'],
					),
				'contain' => array(
					'Employee' => array(
						'User',
						),
					),
				));
			foreach ($contacts['Employee'] as $contact) :
				if(!empty($contact['User'])) : 
					$users[] = $contact['User'];
				endif;
			endforeach;
		endif;
		
		if (!empty($users)) :
			$i=0;
			foreach ($users as $user) : 
				$model->data['User'][$i]['user_id'] = $user['id'];
				$model->data['User'][$i]['model'] = $model->name;
				$model->data['User'][$i]['role'] = $this->defaultRole; // temporary, until we start doing real acl within systems
				$i++;
			endforeach;
		endif;
		return $model->data;
	}
	
}
?>
<?php
class UsableBehavior extends ModelBehavior {

	public $model = '';
	public $foreignKey = '';
	public $defaultRole = '';
	public $userData = array();
	public $superAdminRoleId = 1;
	public $restrictRedirect = false;


	public function setup(&$Model, $settings = array()) {
		$this->defaultRole = !empty($settings['defaultRole']) ? $settings['defaultRole'] : null;
		$this->superAdminRoleId = defined('__USERS_SUPER_ADMIN_ROLE_ID') ? __USERS_SUPER_ADMIN_ROLE_ID : $this->superAdminRoleId;
	}


	public function beforeSave(&$Model) {
		#remove habtm user data and give it to the afterSave() function
		if (!empty($Model->data['User']['User'])) :
			$this->userData = $Model->data;
			unset($Model->data['User']['User']);
		endif;
		
		$Model->data = $this->getChildContacts($Model);
		
		return true;
	}
	
	
/**
 * Update the find methods so that we check against the used table that the current user is part of this item being searched.
 *
 * @param {class}		Model class triggering this callback
 * @param {array}		An array specifying the conditions for the query to be triggered.
 * @todo				I'm semi-sure that the big query this makes could be optimized better.  An OR and a NOT IN in one query isn't exactly high performance.   But after 9 hours coming up with that we'll leave optimization for another day. 
 */
	public function beforeFind(&$Model, $queryData) {
		$authUser = CakeSession::read('Auth.User');
		$userRole = $authUser['user_role_id'];
		$userId = $authUser['id'];
		
		if (!empty($userId) /*&& $userRole != $this->superAdminRoleId*/ && empty($queryData['nocheck'])) : 
			#this tells us whether the result would have returned something if UsableBehavior wasn't used
			$queryData['nocheck'] = true;
			#$originalSearchCount = $Model->find('count', $queryData);
			$originalSearchCount = 0;
			if ($originalSearchCount > 0) : $this->restrictRedirect = true; endif;
			
			/*# this allows you to bypass the logged in user check (nocheck should equal the user id)
			$userQuery = !empty($queryData['nocheck']) ? "Used.user_id = '{$queryData['nocheck']}'" : "Used.user_id = '{$userId}'";
			*/ // left because I don't know where nocheck was used
			
			
			/*
			# output the new query
			$queryData['joins'] = array(array(
				'table' => 'used',
				'alias' => 'Used',
				'type' => 'LEFT',
				'conditions' => array(
					"Used.foreign_key = {$Model->alias}.id",
					"Used.model = '{$Model->alias}'",
					$userQuery,
				),
			));*/ // left for reference as its a pretty cool query
			
			$Dbo = $Model->getDataSource();
			
			# First find users with access
			$subQuery = $Dbo->buildStatement(array(
				//'fields' => array('`User2`.`id`'),
				'fields' => array('Used.foreign_key'),
				'table' => 'used',
				'alias' => 'Used',
				'limit' => null,
				'offset' => null,
				'joins' => array(),
				'conditions' => array(
					'Used.model' => "{$Model->alias}",
					'Used.user_id' => $userId,
					),
				'order' => null,
				'group' => null
				), $Model);
			$subQuery = "`{$Model->alias}`.`id` IN (" . $subQuery . ")";
			$subQueryExpression = $Dbo->expression($subQuery);
			
			
			# First model records that aren't accessed controlled
			$subQuery2 = $Dbo->buildStatement(array(
				//'fields' => array('`User2`.`id`'),
				'fields' => array('Used.foreign_key'),
				'table' => 'used',
				'alias' => 'Used',
				'limit' => null,
				'offset' => null,
				'joins' => array(),
				'conditions' => array(
					'Used.model' => "{$Model->alias}",
					),
				'order' => null,
				'group' => null
				), $Model);
			$subQuery2 = "`{$Model->alias}`.`id` NOT IN (" . $subQuery2 . ")";
			$subQueryExpression2 = $Dbo->expression($subQuery2);
			
			
			$newQueryData['conditions'][]['OR'] = array('('.$subQueryExpression->value.')', '('.$subQueryExpression2->value.')'); 			
			$queryData = Set::merge($queryData, $newQueryData);
			
			/* Example of the query we're running here.
			SELECT `Project`.`id`
			FROM `projects` AS `Project` 
			WHERE `Project`.`is_archived` = '0' 
			AND (
				 ((
				 	`Project`.`id` IN (
						SELECT `Used`.`foreign_key` 
						FROM used AS Used 
						WHERE `Used`.`model` = 'Project' 
						AND `Used`.`user_id` = 1 )
				 )) OR ((
					`Project`.`id` NOT IN (
						SELECT `Used`.`foreign_key` 
						FROM used AS Used 
						WHERE `Used`.`model` = 'Project' )
				 ))
				) 
			LIMIT 25
			*/		
		endif;		
		
		return $queryData;
	}
	


/**
 * Redirects to restricted if beforeFind emptied the results that would have otherwise not been empty
 *
 * @param {class} 		Model class triggering this callback
 * @param {array}		The data returned from the find query
 */
	public function afterFind(&$Model, $results) {
		if(empty($results) && str_replace('/', '', $_SERVER['REQUEST_URI']) != 'usersusersrestricted' && $this->restrictRedirect) : 
			header("Location: /users/users/restricted");
			break;
		endif;
	}
	
	
	
/**
 * Callback used to save related users, into the used table, with the proper relationship.
 */
	public function afterSave(&$Model, $created) {
		# get current users using, so that we can merge and keep duplicates out later
		$currentUsers = $this->findUsedUsers($Model, $foreignKey = $Model->data[$Model->alias]['id'], $type = 'all');
		
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
		if (!empty($users)) :
			$users = Set::extract('/id', $users);
			$currentUsers = Set::extract('/User/id', $currentUsers);
			$users = array_diff($users, $currentUsers);
		
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
	
	
/**
 * finds used objects based on the userId specified and model asking for this function.
 * uses standard find() parameters after userId
 */
	public function findUsedObjects(&$Model, $userId = null, $type = 'list', $params = array()) {
		$joins = array('joins' => array(array(
			'table' => 'used',
			'alias' => 'Used',
			'type' => 'INNER',
			'conditions' => array(
				"Used.user_id = {$userId}",
				"Used.model = '{$Model->alias}'",
				"Used.foreign_key = {$Model->alias}.id",
				),
			)));
		# note : Last changed this based on adding a user here : /projects/projects/people/{id}
		# make sure it still works there if changed.
		$params = !empty($params) ? array_merge($joins, $params) : $joins;
		# we can do a simple find with the model, because beforeFind of usable limits the results by user
		$results = $Model->find($type, $params);
		if (!empty($results)) : 
			return $results;
		else : 
			return array();
		endif;
	}
	
	
/**
 * finds users based on the foreign_key specified and model asking for this function.
 * uses standard find() parameters after foreignKey
 */
	public function findUsedUsers(&$Model, $foreignKey = null, $type = 'list', $params = null) {
		$joins = array('joins' => array(array(
			'table' => 'used',
			'alias' => 'Used',
			'type' => 'INNER',
			'conditions' => array(
				"Used.foreign_key = '{$foreignKey}'",
				"Used.model = '{$Model->alias}'",
				"Used.user_id = User.id",
				),
			)));
		$params = !empty($params) ? array_merge($joins, $params) : $joins;
		
		$Model->bindModel(array(
			'hasMany' => array(
				'Used' => array(
					'className' => 'Users.Used',
					'foreignKey' => 'foreign_key',
					),
				),
			));
		
		$results = $Model->Used->User->find($type, $params);
		if (!empty($results)) : 
			return $results;
		else : 
			return array();
		endif;
	}
	
	
/** 
 * Add a used user to an object
 */
	public function addUsedUser(&$Model, $data) {
		# do a check to see if the user is already a part of this object (we don't want duplicates)
		$objects = $this->findUsedObjects($Model, $data['Used']['user_id'], 'all', array('conditions' => array('Used.foreign_key' => $data['Used']['foreign_key'])));
		$objectIds = Set::extract("/{$Model->alias}/id", $objects);
		if (array_search($data['Used']['foreign_key'], $objectIds)) : 
			throw new Exception('User is already involved.');
		else : 
			if ($Model->Used->saveAll($data)) : 
				return true;
			else : 
				throw new Exception('User add failed.');
			endif;
		endif;
	}
	
	
/** 
 * Remove used users from the object
 */
	public function removeUsedUser(&$Model, $userId = null, $foreignKey = null) {
		if ($Model->Used->deleteAll(array('Used.user_id' => $userId, 'Used.foreign_key' => $foreignKey))) : 
			return true;
		else : 
			return false;
		endif;
	}
	
	
/**
 * Find child contacts of a parent contact and add them to the data user list
 */
	public function getChildContacts(&$Model) {
		if (!empty($Model->data[$Model->alias]['contact_id']) && $Model->data[$Model->alias]['contact_all_access']) : 
			# add all of the companies people to the used table
			# note, if the model has contact_id, then it should belongTo Contact
			$contacts = $Model->Contact->Employer->find('first', array(
				'conditions' => array(
					'Employer.id' => $Model->data[$Model->alias]['contact_id'],
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
				$Model->data['User'][$i]['user_id'] = $user['id'];
				$Model->data['User'][$i]['model'] = $Model->name;
				$Model->data['User'][$i]['role'] = $this->defaultRole; // temporary, until we start doing real acl within systems
				$i++;
			endforeach;
		endif;
		return $Model->data;
	}
	
}
?>
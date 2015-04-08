<?php
/**
 *@property UserGroup UserGroup
 */
class AppUserGroupsController extends UsersAppController {

	public $name = 'UserGroups';
	public $uses = 'Users.UserGroup';

	public function index() {
		$this->UserGroup->recursive = 0;
		$this->paginate['contain'][] = 'Creator';
		$this->set('userGroups', $this->request->data = $this->paginate());
		return $this->request->data;
	}

/**
 * get cureent logged in user's groups
 * @return array |
 */
	public function my() {
		$uid = $this->userId;
		$this->paginate['contain'] = array('UserGroup', 'Moderator');
		$this->paginate['conditions'] = array('UsersUserGroup.user_id' => $uid, 'UsersUserGroup.is_moderator' => 1);
		$this->set('userGroups', $this->paginate('UsersUserGroup'));
		$this->view = 'index';
	}

/**
 * This action returns data for an element
 *
 * @todo make a proper settings array merge
 */
	public function groupActivity ($id = null, $options = array()) {

		if ( !isset($options['limit']) ) {
			$options['limit'] = 3;
		}

		$userGroup  = $this->UserGroup->find('first', array(
			'conditions'=>array(
				'UserGroup.id' => $id
				),
			'contain'=>array(
				'Creator'=>array(
					'fields'=>array(
						'id',
						'username',
						'full_name',
						)
					),
				'User'=>array(
					'fields'=>array(
						'id',
						'username',
						'full_name',
						)
					),
				'UserGroupWallPost' => array(
					'order' => array('UserGroupWallPost.created' => 'DESC'),
					'Creator',
					'Comment'
				)
			),
			'limit' => $options['limit']
		));

		return $userGroup;

	}

	public function view($id = null) {
		$this->UserGroup->id = $id;

		if (!$this->UserGroup->exists()) {
			throw new NotFoundException(__('Invalid user group'));
		}

		$userGroup  = $this->UserGroup->find('first', array(
			'conditions'=>array(
				'UserGroup.id' => $id
				),
			'contain'=>array(
				'Creator'=>array(
					'fields'=>array(
						'id',
						'username',
						'full_name',
						)
					),
				'User'=>array(
					'fields'=>array(
						'id',
						'username',
						'full_name',
						'facebook_id'
						)
					),
				'UserGroupWallPost' => array(
					'Creator',
					'Comment' => array(
						'User' => array('fields' => array('User.id', 'User.full_name'))
					),
				),
			)
		));
		$this->set('userGroup', $this->request->data = $userGroup);
		$this->set('userId' , $this->Session->read('Auth.User.id'));
		// get the logged in users group status
		$status = $this->UserGroup->findUserGroupStatus('first', array(
			'conditions' => array(
				'UsersUserGroup.user_group_id' => $id,
				),
			));
		$this->set(compact('status'));
		$this->set('page_title_for_layout' , $userGroup['UserGroup']['title'] . ' < ' . __('User Group') . ' | '. __SYSTEM_SITE_NAME);
	}

/**
 * Add method
 *
 * @param null
 * @return void
 * @todo	Move most of this to the model
 */
	public function add() {
		if (!empty($this->request->data)) {
			$this->request->data["UserGroup"]["creator"] = $this->Auth->user('id');
			$this->UserGroup->create();
			if ($this->UserGroup->save($this->request->data)) {
				// Set the data for the join table the creator has to be the moderator.
				$pg_data = array(
					'UsersUserGroup' => array(
						'user_id' => $this->Auth->user('id'),
						'user_group_id' => $this->UserGroup->getLastInsertID(),
						'is_approved' => 1,
						'is_moderator' => 1,
						)
					);
				// save the users user role data
				$this->UserGroup->UsersUserGroup->save($pg_data);
				$this->Session->setFlash(__('Group has been saved', true), 'flash_success');
				$this->redirect(array('plugin'=>'users','controller'=>'user_groups' , 'action'=>'index'));
			} else {
				$this->Session->setFlash(__('Group could not be saved. Please, try again.', true), 'flash_warning');
			}
		}
	}

/**
 * Action to join a group
 *
 * @param int	 group_id -> The id pf the group user wants to join.
 * @param int	 user_id 
 */	
	public function join($group_id , $user_id){
		//set the data 
		// MOVED to the users_user_groups
		
		/*$this->request->data = array(
			'UserGroup'=>array(
				'id'=>$group_id
			),
			'User'=>array(
				'id'=>$user_id
			)
		);
		
		$this->UserGroup->create();
		$this->UserGroup->save($this->request->data);*/
		//$this->redirect(array('plugin'=>'users','controller'=>'user_groups' , 'action'=>'index'));
	}

	public function edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid user role', true), 'flash_danger');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->UserGroup->save($this->request->data)) {
				$this->Session->setFlash(__('Group has been saved', true), 'flash_success');
				$this->redirect(array('action' => 'view', $this->request->data['UserGroup']['id']));
			} else {
				$this->Session->setFlash(__('Group could not be saved. Please, try again.', true), 'flash_warning');
			}
		}
		
		$this->request->data = $this->UserGroup->read(null, $id);
		
		# handle the finding of user groups related to the logged in user (you must be a moderator to manage members)
		if ($userGroups = $this->UserGroup->findUserGroupsByModerator('list')) {
			$users = $this->UserGroup->User->find('list');
			$this->set(compact('users', 'userGroups')); 
		} else {
			$this->Session->setFlash('Invalid Group Credentials', 'flash_warning');
			$this->redirect(array('plugin' => 'users', 'controller' => 'user_groups', 'action' => 'view', $groupId));
		}
	}

/**
 * Delete method
 */
	public function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for group', true), 'flash_danger');
			$this->redirect(array('action'=>'index'));
		}
		if ($this->UserGroup->delete($id)) {
			$this->Session->setFlash(__('Group deleted', true), 'flash_success');
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Group was not deleted', true), 'flash_warning');
		$this->redirect(array('action' => 'index'));
	}
	
/**
 *  Only show groups that a user is the moderator for
 * @deprecated use my instead
 */
	public function mygroups() {
		$this->my();
	}

/**
 * User method
 *
 */
 	public function user($groupId) {
 		if ($this->request->is('post')) {
 			if ($this->UserGroup->user($this->request->data)) {
 				$this->Session->setFlash(__('User created, and added to group.'), 'flash_success');
				$this->redirect(array('plugin' => 'users', 'controller' => 'user_groups', 'action' => 'view', $groupId));
 			} else {
 				$this->Session->setFlash(__('Could not create user.'), 'flash_warning');
 			}
 		}
 		$this->set('userGroup', $this->UserGroup->read(null, $groupId));
 		$this->request->data['UserGroup']['UserGroup'][] = $groupId;
 	}
}

if (!isset($refuseInit)) {
	class UserGroupsController extends AppUserGroupsController {}
}
<?php
class UserGroupsController extends UsersAppController {

	public $name = 'UserGroups';
	public $uses = 'Users.UserGroup';

	public function index() {
		$this->UserGroup->recursive = 0;
		$this->set('userGroups', $this->paginate());
		
	}

	public function view($id = null) {
		$this->UserGroup->id = $id;
		if (!$this->UserGroup->exists()) {
			throw new NotFoundException(__('Invalid catalog item'));
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
					'Creator',
					'Comment' => array(
//						'contain' => array(
//							'User' => array('fields' => array('User.id', 'User.full_name'))
//						)
					),
				),
			)
		));
		
		$this->set('userGroup', $userGroup);
		$this->set('userId' , $this->Session->read('Auth.User.id'));
		# get the logged in users group status
		# @todo this should be reusable
		$status = $this->UserGroup->findUserGroupStatus('first', array(
			'conditions' => array(
				'UsersUserGroup.user_group_id' => $id,
				),
			));
		$this->set(compact('status'));
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
				# Set the data for the join table the creator has to be the moderator.
				$pg_data = array(
					'UsersUserGroup' => array(
						'user_id' => $this->Auth->user('id'),
						'user_group_id' => $this->UserGroup->getLastInsertID(),
						'is_approved' => 1,
						'is_moderator' => 1,
						)
					);
				# save the users user role data 
				$this->UserGroup->UsersUserGroup->save($pg_data);
				$this->Session->setFlash(__('Group has been saved', true));
				$this->redirect(array('plugin'=>'users','controller'=>'user_groups' , 'action'=>'index'));
			} else {
				$this->Session->setFlash(__('Group could not be saved. Please, try again.', true));
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
			$this->Session->setFlash(__('Invalid user role', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->UserGroup->save($this->request->data)) {
				$this->Session->setFlash(__('Group has been saved', true));
				$this->redirect(array('action' => 'view', $this->request->data['UserGroup']['id']));
			} else {
				$this->Session->setFlash(__('Group could not be saved. Please, try again.', true));
			}
		}
		
		$this->request->data = $this->UserGroup->read(null, $id);
		
		# handle the finding of user groups related to the logged in user (you must be a moderator to manage members)
		if ($userGroups = $this->UserGroup->findUserGroupsByModerator('list')) {
			$users = $this->UserGroup->User->find('list');
			$this->set(compact('users', 'userGroups')); 
		} else {
			$this->Session->setFlash('Invalid Group Credentials');
			$this->redirect(array('plugin' => 'users', 'controller' => 'user_groups', 'action' => 'view', $groupId));
		}
	}

	public function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for group', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->UserGroup->delete($id)) {
			$this->Session->setFlash(__('Group deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Group was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>
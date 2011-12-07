<?php
class UserGroupsController extends UsersAppController {

	var $name = 'UserGroups';

	function index() {
		$this->UserGroup->recursive = 0;
		$this->set('userGroups', $this->paginate());
		
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid user role', true));
			$this->redirect(array('action' => 'index'));
		}
		
		$pgData  = $this->UserGroup->find('first', array(
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
						),
				)
			));
		$this->set('userGroup', $pgData);
		$this->set('userId' , $this->Session->read('Auth.User.id'));
		// get the users user role record to have info about group status
		$userGroups = $this->UserGroup->UsersUserGroup->find('first' , array(
			'conditions' => array(
				'user_id' => $this->Session->read('Auth.User.id'),
				'user_group_id' => $pgData['UserGroup']['id']
				),
			'contain' => array()
			));
		$this->set('u_dat' , $userGroups);
	}

	function add() {
		if (!empty($this->request->data)) {
			$this->request->data["UserGroup"]["creator"] = $this->Auth->user('id');
			$this->UserGroup->create();
			if ($this->UserGroup->save($this->request->data)) {
				//Set the data for the join table the creator has to be the moderator.
				$pg_data = array(
					'UsersUserGroup'=>array(
						'user_id'=>$this->Auth->user('id'),
						'user_group_id'=>$this->UserGroup->getLastInsertID(),
						'is_approved'=>1,
						'is_moderator'=>1
					)
				);
				// save the users user role data 
				$this->UserGroup->UsersUserGroup->create();
				$this->UserGroup->UsersUserGroup->save($pg_data);
				$this->Session->setFlash(__('Group has been saved', true));
				$this->redirect(array('plugin'=>'users','controller'=>'user_groups' , 'action'=>'index'));
			} else {
				$this->Session->setFlash(__('Group could not be saved. Please, try again.', true));
			}
		}
	}
	
	/*
	 * Action to join a group
	 * @param {int} group_id -> The id pf the group user wants to join.
	 * @param {int} user_id 
	 */
	
	function join($group_id , $user_id){
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

	function edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid user role', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->UserGroup->save($this->request->data)) {
				$this->Session->setFlash(__('Group has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('Group could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->UserGroup->read(null, $id);
		}
	}

	function delete($id = null) {
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
	function admin_index() {
		$this->UserGroup->recursive = 0;
		$this->set('userGroups', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid group', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('userGroup', $this->UserGroup->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->request->data)) {
			$this->UserGroup->create();
			if ($this->UserGroup->save($this->request->data)) {
				$this->Session->setFlash(__('Group has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('Group could not be saved. Please, try again.', true));
			}
		}
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid group', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->UserGroup->save($this->request->data)) {
				$this->Session->setFlash(__('Group has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('Group could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->UserGroup->read(null, $id);
		}
	}

	function admin_delete($id = null) {
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
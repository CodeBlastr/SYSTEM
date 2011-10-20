<?php
class UsersUserGroupsController extends UsersAppController {

	var $name = 'UsersUserGroups';

	function index() {
		$this->paginate['contain'] = array('User', 'UserGroup');
		$this->set('usersUserGroups', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->flash(__('Invalid users user goup', true), array('action' => 'index'));
		}
		$this->set('usersUserGroup', $this->UsersUserGroup->read(null, $id));
	}
	
	/*
	 * Action to join a group
	 * @param {int} groupId -> The id pf the group user wants to join.
	 * @param {int} userId 
	 * @todo  Change this to a try catch syntax and put most of it in the model
	 * @todo  Consider putting the first part into a fully different function.  Its more of a friend type of add, or a quick_add (that might be a good name) than just add().  And we will definitely need different permissions.  As it is now, its like an admin function, not an end user function. 
	 */
	function add() {
		if ($groupId = $this->request->data['UsersUserGroup']['user_group_id'] && $userId = $this->request->data['UsersUserGroup']['user_id']) : 
			# check if user is already in this grpoup or not
			$cnt = $this->UsersUserGroup->find('count' , array(
				'conditions'=>array(
					'user_group_id' => $groupId,
					'user_id' => $userId
					),
				'contain'=>array()
			));
			if($cnt == 0){
				$this->UsersUserGroup->create();
				if ($this->UsersUserGroup->save($this->request->data)) {
					$this->Session->setFlash('Joined Group Successfully');
					$this->redirect(array('plugin'=>'users','controller'=>'user_groups' , 'action'=>'index'));
				} 				
			} else {
				$this->Session->setFlash('User is already in this group');
				$this->redirect(array('plugin' => 'users', 'controller'=>'user_groups' , 'action'=>'view', $groupId));
			}
		elseif ($this->Session->read('Auth.User.id')) : 
			# handle the finding of user groups related to the logged in user (you must be a moderator to manage members)
			if ($userGroups = $this->UsersUserGroup->UserGroup->findUserGroupsByModerator($this->Session->read('Auth.User.id'), 'list')) : 
				$users = $this->UsersUserGroup->User->find('list');
				$this->set(compact('users', 'userGroups')); 
			else : 
				$this->Session->setFlash('Invalid Group Credentials');
				$this->redirect(array('plugin' => 'users', 'controller'=>'user_groups' , 'action'=>'view', $groupId));
			endif;
		endif;
		$this->set('page_title_for_layout', 'Add a User to a Group');
		$this->set('title_for_layout', 'Group add user form');
	}


	function edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->flash(sprintf(__('Invalid users user goup', true)), array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->UsersUserGroup->save($this->request->data)) {
				$this->Session->setFlash(__('User and group updated.', true));
				$this->redirect(array('plugin' => 'users', 'controller'=>'user_groups' , 'action'=>'view', $this->request->data['UsersUserGroup']['user_group_id']));
			} else {
				$this->Session->setFlash('Update failed.');
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->UsersUserGroup->read(null, $id);
		}
		$users = $this->UsersUserGroup->User->find('list');
		$userGroups = $this->UsersUserGroup->UserGroup->find('list');
		$this->set(compact('users', 'userGroups'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->flash(sprintf(__('Invalid users user goup', true)), array('action' => 'index'));
		}
		if ($this->UsersUserGroup->delete($id)) {
			$this->flash(__('Users user goup deleted', true), array('action' => 'index'));
		}
		$this->flash(__('Users user goup was not deleted', true), array('action' => 'index'));
		$this->redirect(array('action' => 'index'));
	}
	function admin_index() {
		$this->UsersUserGroup->recursive = 0;
		$this->set('usersUserGroups', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->flash(__('Invalid users user goup', true), array('action' => 'index'));
		}
		$this->set('usersUserGroup', $this->UsersUserGroup->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->request->data)) {
			$this->UsersUserGroup->create();
			if ($this->UsersUserGroup->save($this->request->data)) {
				$this->flash(__('Usersusergoup saved.', true), array('action' => 'index'));
			} else {
			}
		}
		$users = $this->UsersUserGroup->User->find('list');
		$userGroups = $this->UsersUserGroup->UserGroup->find('list');
		$this->set(compact('users', 'userGroups'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->flash(sprintf(__('Invalid users user goup', true)), array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->UsersUserGroup->save($this->request->data)) {
				$this->flash(__('The users user goup has been saved.', true), array('action' => 'index'));
			} else {
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->UsersUserGroup->read(null, $id);
		}
		$users = $this->UsersUserGroup->User->find('list');
		$userGroups = $this->UsersUserGroup->UserGroup->find('list');
		$this->set(compact('users', 'userGroups'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->flash(sprintf(__('Invalid users user goup', true)), array('action' => 'index'));
		}
		if ($this->UsersUserGroup->delete($id)) {
			$this->flash(__('Users user goup deleted', true), array('action' => 'index'));
		}
		$this->flash(__('Users user goup was not deleted', true), array('action' => 'index'));
		$this->redirect(array('action' => 'index'));
	}
}
?>
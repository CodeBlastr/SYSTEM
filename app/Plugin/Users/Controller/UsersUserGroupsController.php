<?php
class UsersUserGroupsController extends UsersAppController {

	public $name = 'UsersUserGroups';
	public $uses = 'Users.UsersUserGroup';

	public function index() {
		$this->paginate['contain'] = array('User', 'UserGroup');
		$this->set('usersUserGroups', $this->paginate());
	}

	public function view($id = null) {
		if (!$id) {
			$this->flash(__('Invalid users user goup', true), array('action' => 'index'));
		}
		$this->set('usersUserGroup', $this->UsersUserGroup->read(null, $id));
	}
	
/**
 * Add user to group method
 *
 * @param {int} groupId -> The id pf the group user wants to join.
 * @param {int} userId 
 * @todo  Change this to a try catch syntax and put most of it in the model
 * @todo  Consider putting the first part into a fully different function.  Its more of a friend type of add, or a quick_add (that might be a good name) than just add().  And we will definitely need different permissions.  As it is now, its like an admin function, not an end user function. 
 */
	public function add() {
		$userId = $this->Session->read('Auth.User.id');
		if (!empty($this->request->data)) {
			try {
				$this->UsersUserGroup->add($this->request->data);
				$this->Session->setFlash('Joined Group Successfully');
				$this->redirect(array('plugin' => 'users', 'controller' => 'user_groups', 'action' => 'view', $this->request->data['UsersUserGroup']['user_group_id']));
			} catch (Exception $e) {
				$this->Session->setFlash($e->getMessage());
			}
		} 
		
		# handle the finding of user groups related to the logged in user (you must be a moderator to manage members)
		if ($userGroups = $this->UsersUserGroup->UserGroup->findUserGroupsByModerator('list')) {
			$users = $this->UsersUserGroup->User->find('list');
			$this->set(compact('users', 'userGroups')); 
		} else {
			$this->Session->setFlash('Invalid Group Credentials');
			$this->redirect(array('plugin' => 'users', 'controller' => 'user_groups', 'action' => 'view', $groupId));
		}
		
		$this->set('page_title_for_layout', 'Add a User to a Group');
		$this->set('title_for_layout', 'Group add user form');
	}


	public function edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->flash(sprintf(__('Invalid users user goup', true)), array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->UsersUserGroup->save($this->request->data)) {
				$this->Session->setFlash(__('User and group updated.'));
				$this->redirect(array('plugin' => 'users', 'controller' => 'user_groups', 'action' => 'view', $this->request->data['UsersUserGroup']['user_group_id']));
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

	public function delete($id = null) {
		if (!$id) {
			$this->flash(sprintf(__('Invalid', true)), array('action' => 'index'));
		}
		if ($this->UsersUserGroup->delete($id)) {
			$this->Session->setFlash(__('User removed from group.'));
			$this->redirect($this->referer());
		}
		$this->Session->setFlash(__('Error : User was not removed from group please try again.'));
		$this->redirect($this->referer());
	}
}
?>
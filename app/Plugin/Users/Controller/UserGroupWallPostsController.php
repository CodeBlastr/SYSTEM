<?php
class UserGroupWallPostsController extends UsersAppController {

	public $name = 'UserGroupWallPosts';
	public $uses = 'Users.UserGroupWallPost';

	function index() {
		$this->UserGroupWallPost->recursive = 0;
		$this->set('userGroupWallPosts', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->flash(__('Invalid user role wall post', true), array('action' => 'index'));
		}
		$this->set('userGroupWallPost', $this->UserGroupWallPost->read(null, $id));
	}

	/*
	 * Adds a user Group Wall Post
	 * @param {int} group_id 
	 * 
	 */
	function add($group_id) {
		if (!empty($this->request->data)) {
			$this->request->data["UserGroupWallPost"]["creator_id"] = $this->Auth->user('id');
			$this->request->data["UserGroupWallPost"]["user_group_id"] = $group_id;
			$this->UserGroupWallPost->create();
			if ($this->UserGroupWallPost->save($this->request->data)) {
				$this->redirect(array('plugin'=>'users','controller'=>'user_groups' , 'action'=>'view', $group_id));
			} 
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->flash(sprintf(__('Invalid user role wall post', true)), array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->UserGroupWallPost->save($this->request->data)) {
				$this->flash(__('The user role wall post has been saved.', true), array('action' => 'index'));
			} else {
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->UserGroupWallPost->read(null, $id);
		}
		$userGroups = $this->UserGroupWallPost->UserGroup->find('list');
		$this->set(compact('userGroups'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->flash(sprintf(__('Invalid user role wall post', true)), array('action' => 'index'));
		}
		if ($this->UserGroupWallPost->delete($id)) {
			$this->flash(__('User group wall post deleted', true), array('action' => 'index'));
		}
		$this->flash(__('User group wall post was not deleted', true), array('action' => 'index'));
		$this->redirect(array('action' => 'index'));
	}
	function admin_index() {
		$this->UserGroupWallPost->recursive = 0;
		$this->set('userGroupWallPosts', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->flash(__('Invalid user role wall post', true), array('action' => 'index'));
		}
		$this->set('userGroupWallPost', $this->UserGroupWallPost->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->request->data)) {
			$this->UserGroupWallPost->create();
			if ($this->UserGroupWallPost->save($this->request->data)) {
				$this->flash(__('Usergroupwallpost saved.', true), array('action' => 'index'));
			} else {
			}
		}
		$userGroups = $this->UserGroupWallPost->UserGroup->find('list');
		$this->set(compact('userGroups'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->flash(sprintf(__('Invalid user role wall post', true)), array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->UserGroupWallPost->save($this->request->data)) {
				$this->flash(__('The user role wall post has been saved.', true), array('action' => 'index'));
			} else {
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->UserGroupWallPost->read(null, $id);
		}
		$userGroups = $this->UserGroupWallPost->UserGroup->find('list');
		$this->set(compact('userGroups'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->flash(sprintf(__('Invalid user role wall post', true)), array('action' => 'index'));
		}
		if ($this->UserGroupWallPost->delete($id)) {
			$this->flash(__('User group wall post deleted', true), array('action' => 'index'));
		}
		$this->flash(__('User group wall post was not deleted', true), array('action' => 'index'));
		$this->redirect(array('action' => 'index'));
	}
}
?>
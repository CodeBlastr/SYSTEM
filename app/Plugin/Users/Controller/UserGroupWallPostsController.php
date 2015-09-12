<?php
App::uses('UsersAppController', 'Users.Controller');

class AppUserGroupWallPostsController extends UsersAppController {

	public $name = 'UserGroupWallPosts';
	public $uses = 'Users.UserGroupWallPost';

	public function index() {
		$this->UserGroupWallPost->recursive = 0;
		$this->set('userGroupWallPosts', $this->paginate());
	}

	public function view($id = null) {
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
	public function add($groupId = null) {
		if ($this->request->is('post')) {
			$this->request->data['UserGroupWallPost']['creator_id'] = $this->Auth->user('id');
			$this->request->data['UserGroupWallPost']['user_group_id'] = !empty($this->request->data['UserGroupWallPost']['user_group_id']) ? $this->request->data['UserGroupWallPost']['user_group_id'] : $groupId;
			$this->UserGroupWallPost->create();
			if ($this->UserGroupWallPost->save($this->request->data)) {
				$this->redirect(array('plugin'=>'users','controller'=>'user_groups' , 'action'=>'view', $groupId));
			} 
		}
	}

	public function edit($id = null) {
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

/**
 * Delete method
 * 
 */
	public function delete($id = null) {
		$this->UserGroupWallPost->id = $id;
		if (!$this->UserGroupWallPost->exists()) {
			throw new NotFoundException(__('Invalid post'));
		}
		if ($this->UserGroupWallPost->delete($id)) {
			$this->Session->setFlash('Post deleted.', 'flash_success');
		} else {
			$this->Session->setFlash('Error deleting post, please try again.', 'flash_danger');
		}
		$this->redirect($this->referer());
	}
}

if (!isset($refuseInit)) {
	class UserGroupWallPostsController extends AppUserGroupWallPostsController {}
}
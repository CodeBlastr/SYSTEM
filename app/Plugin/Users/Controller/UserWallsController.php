<?php

class UserWallsController extends UsersAppController {

	public $name = 'UserWalls';
	public $uses = 'Users.UserWall';

/**
 * 
 */
	function index() {
		$this->UserWall->recursive = 0;
		$this->set('userWalls', $this->paginate());
	}

/**
 * 
 * @param int $id
 */
	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid user wall', true), 'flash_danger');
		}
		$this->set('userWall', $this->UserWall->read(null, $id));
	}

/**
 * Adds a post to someones wall
 * @param int $user_id
 */
	function add($user_id) {
		if (!empty($this->request->data)) {
			$this->request->data['UserWall']['user_id'] = $user_id;
			$this->request->data['UserWall']['creator_id'] = $this->Auth->user('id');
			$this->UserWall->create();
			if ($this->UserWall->save($this->request->data)) {
				$this->redirect(array('controller' => 'users', 'action' => 'view', 'user_id' => $user_id));
			} else {
				$this->redirect($this->referer());
			}
		}
	}

/**
 * 
 * @param int $id
 */
	function edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(sprintf(__('Invalid user wall', true)), 'flash_danger');
		}
		if (!empty($this->request->data)) {
			if ($this->UserWall->save($this->request->data)) {
				$this->Session->setFlash(__('The user wall has been saved.', true), 'flash_success');
			} else {
				$this->Session->setFlash(__('The user wall was not saved.', true), 'flash_warning');
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->UserWall->read(null, $id);
		}
	}

/**
 * 
 * @param int $id
 */
	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid user wall', true)), 'flash_danger');
		}
		if ($this->UserWall->delete($id)) {
			$this->Session->setFlash(__('User wall deleted', true), 'flash_success');
		} else {
			$this->Session->setFlash(__('User wall was not deleted', true), 'flash_warning');
		}
		$this->redirect($this->referer());
	}

}

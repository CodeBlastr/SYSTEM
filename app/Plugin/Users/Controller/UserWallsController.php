<?php
class UserWallsController extends UsersAppController {

	var $name = 'UserWalls';

	function index() {
		$this->UserWall->recursive = 0;
		$this->set('userWalls', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->flash(__('Invalid user wall', true), array('action' => 'index'));
		}
		$this->set('userWall', $this->UserWall->read(null, $id));
	}
	
	/*
	 * Adds a post to someones wall 
	 * @param {int} user_id 
	 * @return void
	 */

	function add($user_id) {
		if (!empty($this->data)) {
			$this->data['UserWall']['user_id'] = $user_id;
			$this->data['UserWall']['creator_id'] = $this->Auth->user('id');
			$this->UserWall->create();
			if ($this->UserWall->save($this->data)) {
				$this->redirect(array('plugin'=>'users', 'controller'=>'users' , 'action'=>'view' , 'user_id'=>$user_id));
			} else {
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->flash(sprintf(__('Invalid user wall', true)), array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->UserWall->save($this->data)) {
				$this->flash(__('The user wall has been saved.', true), array('action' => 'index'));
			} else {
			}
		}
		if (empty($this->data)) {
			$this->data = $this->UserWall->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->flash(sprintf(__('Invalid user wall', true)), array('action' => 'index'));
		}
		if ($this->UserWall->delete($id)) {
			$this->flash(__('User wall deleted', true), array('action' => 'index'));
		}
		$this->flash(__('User wall was not deleted', true), array('action' => 'index'));
		$this->redirect(array('action' => 'index'));
	}
	function admin_index() {
		$this->UserWall->recursive = 0;
		$this->set('userWalls', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->flash(__('Invalid user wall', true), array('action' => 'index'));
		}
		$this->set('userWall', $this->UserWall->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->UserWall->create();
			if ($this->UserWall->save($this->data)) {
				$this->flash(__('Userwall saved.', true), array('action' => 'index'));
			} else {
			}
		}
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->flash(sprintf(__('Invalid user wall', true)), array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->UserWall->save($this->data)) {
				$this->flash(__('The user wall has been saved.', true), array('action' => 'index'));
			} else {
			}
		}
		if (empty($this->data)) {
			$this->data = $this->UserWall->read(null, $id);
		}
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->flash(sprintf(__('Invalid user wall', true)), array('action' => 'index'));
		}
		if ($this->UserWall->delete($id)) {
			$this->flash(__('User wall deleted', true), array('action' => 'index'));
		}
		$this->flash(__('User wall was not deleted', true), array('action' => 'index'));
		$this->redirect(array('action' => 'index'));
	}
}
?>
<?php
class UserWallsController extends UsersAppController {

	public $name = 'UserWalls';
	public $uses = 'Users.UserWall';

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
		if (!empty($this->request->data)) {
			$this->request->data['UserWall']['user_id'] = $user_id;
			$this->request->data['UserWall']['creator_id'] = $this->Auth->user('id');
			$this->UserWall->create();
			if ($this->UserWall->save($this->request->data)) {
				$this->redirect(array('plugin'=>'users', 'controller'=>'users' , 'action'=>'view' , 'user_id'=>$user_id));
			} else {
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->flash(sprintf(__('Invalid user wall', true)), array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->UserWall->save($this->request->data)) {
				$this->flash(__('The user wall has been saved.', true), array('action' => 'index'));
			} else {
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->UserWall->read(null, $id);
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
}
?>
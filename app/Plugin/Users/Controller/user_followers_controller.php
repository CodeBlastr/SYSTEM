<?php
class UserFollowersController extends UsersAppController {

	var $name = 'UserFollowers';

	function index() {
		$this->UserFollower->recursive = 0;
		$this->set('userfollowers', $this->paginate());
	}

	function view($user = null) {
		$dat = $this->UserFollower->find('all', array(
									'conditions'=>array(
										'UserFollower.user_id'=>$user
									),
									'contain'=>array('User')
		));
		$this->set('dat' , $dat);
	}
	
	/*
	 * 
	 * Follow a user 
	 * @param {int} uid => The id of the user
	 */

	function add($uid) {
		$this->data['UserFollower']['user_id'] = $uid;
		$this->data['UserFollower']['follower_id'] = $this->Auth->user('id');	
		$this->UserFollower->create();
		if ($this->UserFollower->save($this->data)) {
			$this->redirect(array('plugin'=>'users','controller'=>'users' , 'action'=>'view', $uid));
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->flash(sprintf(__('Invalid user follower', true)), array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->UserFollower->save($this->data)) {
				$this->flash(__('The user follower has been saved.', true), array('action' => 'index'));
			} else {
			}
		}
		if (empty($this->data)) {
			$this->data = $this->UserFollower->read(null, $id);
		}
		$users = $this->UserFollower->User->find('list');
		$this->set(compact('users'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->flash(sprintf(__('Invalid user follower', true)), array('action' => 'index'));
		}
		if ($this->UserFollower->delete($id)) {
			$this->flash(__('User follower deleted', true), array('action' => 'index'));
		}
		$this->flash(__('User follower was not deleted', true), array('action' => 'index'));
		$this->redirect(array('action' => 'index'));
	}
	function admin_index() {
		$this->UserFollower->recursive = 0;
		$this->set('userfollowers', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->flash(__('Invalid user follower', true), array('action' => 'index'));
		}
		$this->set('userfollower', $this->UserFollower->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->UserFollower->create();
			if ($this->UserFollower->save($this->data)) {
				$this->flash(__('UserFollower saved.', true), array('action' => 'index'));
			} else {
			}
		}
		$users = $this->UserFollower->User->find('list');
		$this->set(compact('users'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->flash(sprintf(__('Invalid user follower', true)), array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->UserFollower->save($this->data)) {
				$this->flash(__('The user follower has been saved.', true), array('action' => 'index'));
			} else {
			}
		}
		if (empty($this->data)) {
			$this->data = $this->UserFollower->read(null, $id);
		}
		$users = $this->UserFollower->User->find('list');
		$this->set(compact('users'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->flash(sprintf(__('Invalid user follower', true)), array('action' => 'index'));
		}
		if ($this->UserFollower->delete($id)) {
			$this->flash(__('User follower deleted', true), array('action' => 'index'));
		}
		$this->flash(__('User follower was not deleted', true), array('action' => 'index'));
		$this->redirect(array('action' => 'index'));
	}
}
?>

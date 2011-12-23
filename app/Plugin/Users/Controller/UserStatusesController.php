<?php
class UserStatusesController extends UsersAppController {

	public $name = 'UserStatuses';
	public $uses = 'Users.UserStatus';

	function index() {
		$this->UserStatus->recursive = 0;
		$this->set('userStatuses', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->flash(__('Invalid user status', true), array('action' => 'index'));
		}
		$this->set('userStatus', $this->UserStatus->read(null, $id));
	}

	function add() {
		if (!empty($this->request->data)) {
			$this->request->data['UserStatus']['creator_id'] = $this->Auth->user('id');
			$this->UserStatus->create();
			if ($this->UserStatus->save($this->request->data)) {
				$this->flash(__('Status saved.', true), array('action' => 'index'));
				$this->redirect(array( 'plugin'=>'users', 'controller'=>'users' , 'action'=>'my'));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->flash(sprintf(__('Invalid user status', true)), array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->UserStatus->save($this->request->data)) {
				$this->flash(__('Status updated.', true), array('action' => 'index'));
			} else {
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->UserStatus->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->flash(sprintf(__('Invalid user status', true)), array('action' => 'index'));
		}
		if ($this->UserStatus->delete($id)) {
			$this->flash(__('User status deleted', true), array('action' => 'index'));
		}
		$this->flash(__('User status was not deleted', true), array('action' => 'index'));
		$this->redirect(array('action' => 'index'));
	}
}
?>
<?php
class UserGroupsController extends AppController {

	var $name = 'UserGroups';
	
	function beforeFilter() {
	    parent::beforeFilter(); 
	    $this->Auth->allowedActions = array('*');
	}

	function index() {
		$this->UserGroup->recursive = 0;
		$this->set('userGroups', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid UserGroup.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('userGroup', $this->UserGroup->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->UserGroup->create();
			if ($this->UserGroup->save($this->data)) {
				$this->Session->setFlash(__('The UserGroup has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The UserGroup could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid UserGroup', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->UserGroup->save($this->data)) {
				$this->Session->setFlash(__('The UserGroup has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The UserGroup could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->UserGroup->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for UserGroup', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->UserGroup->del($id)) {
			$this->Session->setFlash(__('UserGroup deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}


	function admin_index() {
		$this->UserGroup->recursive = 0;
		$this->set('userGroups', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid UserGroup.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('userGroup', $this->UserGroup->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->UserGroup->create();
			if ($this->UserGroup->save($this->data)) {
				$this->Session->setFlash(__('The UserGroup has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The UserGroup could not be saved. Please, try again.', true));
			}
		}
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid UserGroup', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->UserGroup->save($this->data)) {
				$this->Session->setFlash(__('The UserGroup has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The UserGroup could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->UserGroup->read(null, $id);
		}
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for UserGroup', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->UserGroup->del($id)) {
			$this->Session->setFlash(__('UserGroup deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>
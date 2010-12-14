<?php
class CreditsController extends AppController {

	var $name = 'Credits';

	function index() {
		$this->Credit->recursive = 0;
		$this->set('credits', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid credit', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('credit', $this->Credit->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Credit->create();
			if ($this->Credit->save($this->data)) {
				$this->Session->setFlash(__('The credit has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The credit could not be saved. Please, try again.', true));
			}
		}
		$creditTypes = $this->Credit->CreditType->find('list');
		$users = $this->Credit->User->find('list');
		$creators = $this->Credit->Creator->find('list');
		$modifiers = $this->Credit->Modifier->find('list');
		$this->set(compact('creditTypes', 'users', 'creators', 'modifiers'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid credit', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Credit->save($this->data)) {
				$this->Session->setFlash(__('The credit has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The credit could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Credit->read(null, $id);
		}
		$creditTypes = $this->Credit->CreditType->find('list');
		$users = $this->Credit->User->find('list');
		$creators = $this->Credit->Creator->find('list');
		$modifiers = $this->Credit->Modifier->find('list');
		$this->set(compact('creditTypes', 'users', 'creators', 'modifiers'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for credit', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Credit->delete($id)) {
			$this->Session->setFlash(__('Credit deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Credit was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
	function admin_index() {
		$this->Credit->recursive = 0;
		$this->set('credits', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid credit', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('credit', $this->Credit->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->Credit->create();
			if ($this->Credit->save($this->data)) {
				$this->Session->setFlash(__('The credit has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The credit could not be saved. Please, try again.', true));
			}
		}
		$creditTypes = $this->Credit->CreditType->find('list');
		$users = $this->Credit->User->find('list');
		$creators = $this->Credit->Creator->find('list');
		$modifiers = $this->Credit->Modifier->find('list');
		$this->set(compact('creditTypes', 'users', 'creators', 'modifiers'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid credit', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Credit->save($this->data)) {
				$this->Session->setFlash(__('The credit has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The credit could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Credit->read(null, $id);
		}
		$creditTypes = $this->Credit->CreditType->find('list');
		$users = $this->Credit->User->find('list');
		$creators = $this->Credit->Creator->find('list');
		$modifiers = $this->Credit->Modifier->find('list');
		$this->set(compact('creditTypes', 'users', 'creators', 'modifiers'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for credit', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Credit->delete($id)) {
			$this->Session->setFlash(__('Credit deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Credit was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>
<?php
class ContactDetailsController extends ContactsAppController {

	var $name = 'ContactDetails';

	function index() {
		$this->ContactDetail->recursive = 0;
		$this->set('contactDetails', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid contact detail', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('contactDetail', $this->ContactDetail->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->ContactDetail->create();
			if ($this->ContactDetail->save($this->data)) {
				$this->Session->setFlash(__('The contact detail has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The contact detail could not be saved. Please, try again.', true));
			}
		}
		$contactDetailTypes = $this->ContactDetail->ContactDetailType->find('list');
		$contacts = $this->ContactDetail->Contact->find('list');
		$this->set(compact('contactDetailTypes', 'contacts'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid contact detail', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->ContactDetail->save($this->data)) {
				$this->Session->setFlash(__('The contact detail has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The contact detail could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->ContactDetail->read(null, $id);
		}
		$contactDetailTypes = $this->ContactDetail->ContactDetailType->find('list');
		$contacts = $this->ContactDetail->Contact->find('list');
		$this->set(compact('contactDetailTypes', 'contacts'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for contact detail', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->ContactDetail->delete($id)) {
			$this->Session->setFlash(__('Contact detail deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Contact detail was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>
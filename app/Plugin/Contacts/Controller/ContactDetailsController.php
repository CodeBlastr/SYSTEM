<?php
class ContactDetailsController extends ContactsAppController {

	public $name = 'ContactDetails';
	public $uses = 'Contacts.ContactDetail';

	function index() {
		$this->ContactDetail->recursive = 0;
		$this->set('contactDetails', $this->paginate());
	}

	function view($id = null) {
		$this->ContactDetail->id = $id;
		if (!$this->ContactDetail->exists()) {
			throw new NotFoundException(__('Invalid contact detail.'));
		}
		
		$this->set('contactDetail', $this->ContactDetail->read(null, $id));
	}

	function add() {
		if (!empty($this->request->data)) {
			$this->ContactDetail->create();
			if ($this->ContactDetail->save($this->request->data)) {
				$this->Session->setFlash(__('The contact detail has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The contact detail could not be saved. Please, try again.', true));
			}
		}
		$contactDetailTypes = $this->ContactDetail->types();
		$contacts = $this->ContactDetail->Contact->find('list');
		$this->set(compact('contactDetailTypes', 'contacts'));
	}

	function edit($id = null) {
		$this->ContactDetail->id = $id;
		if (!$this->ContactDetail->exists()) {
			throw new NotFoundException(__('Invalid contact detail.'));
		}

		if (!empty($this->request->data)) {
			if ($this->ContactDetail->save($this->request->data)) {
				$this->Session->setFlash(__('The contact detail has been saved'));
			} else {
				$this->Session->setFlash(__('The contact detail could not be saved. Please, try again.'));
			}
		}
		
		$this->ContactDetail->contain('Contact');
		$this->request->data = $this->ContactDetail->read(null, $id);
		$contactDetailTypes = $this->ContactDetail->types();
		$this->set(compact('contactDetailTypes'));
	}

	function delete($id = null) {
		$this->ContactDetail->id = $id;
		if (!$this->ContactDetail->exists()) {
			throw new NotFoundException(__('Invalid contact detail.'));
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
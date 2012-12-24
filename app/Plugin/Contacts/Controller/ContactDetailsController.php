<?php
class ContactDetailsController extends ContactsAppController {

	public $name = 'ContactDetails';
	public $uses = 'Contacts.ContactDetail';

	public function index() {
		$this->ContactDetail->recursive = 0;
		$this->set('contactDetails', $this->paginate());
	}

	public function view($id = null) {
		$this->ContactDetail->id = $id;
		if (!$this->ContactDetail->exists()) {
			throw new NotFoundException(__('Invalid contact detail.'));
		}
		
		$this->set('contactDetail', $this->ContactDetail->read(null, $id));
	}

	public function add($contactId = null) {
		if (!empty($this->request->data)) {
			$this->ContactDetail->create();
			if ($this->ContactDetail->save($this->request->data)) {
				$this->Session->setFlash(__('The contact detail has been saved', true));
				$this->redirect(array('plugin' => 'contacts', 'controller' => 'contacts', 'action' => 'view', $this->request->data['ContactDetail']['contact_id']));
			} else {
				$this->Session->setFlash(__('The contact detail could not be saved. Please, try again.', true));
			}
		}
		$contactDetailTypes = $this->ContactDetail->types();
		$contacts = $this->ContactDetail->Contact->find('list');
		$this->set(compact('contactDetailTypes', 'contacts', 'contactId'));
	}

	public function edit($id = null) {
		$this->ContactDetail->id = $id;
		if (!$this->ContactDetail->exists()) {
			throw new NotFoundException(__('Invalid contact detail.'));
		}

		if (!empty($this->request->data)) {
			try {
				$this->ContactDetail->save($this->request->data);
				$this->Session->setFlash(__('The contact detail has been saved'));
				$this->redirect(array('controller' => 'contacts', 'action' => 'view', $this->request->data['ContactDetail']['contact_id']));
			} catch(Exception $e) {
				$this->Session->setFlash($e->getMessage);
			}
		}
		
		$this->ContactDetail->contain('Contact');
		$this->request->data = $this->ContactDetail->read(null, $id);
		$this->set('contactDetailTypes', $this->ContactDetail->types());
		$this->set('page_title_for_layout', __('Edit %s', $this->request->data['Contact']['name']));
	}

	public function delete($id = null) {
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
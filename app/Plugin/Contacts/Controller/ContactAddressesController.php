<?php
class ContactAddressesController extends ContactsAppController {

	public $name = 'ContactAddresses';
	public $uses = 'Contacts.ContactAddress';

	function index() {
		$this->ContactAddress->recursive = 0;
		$this->set('contactAddresses', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid contact address', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('contactAddress', $this->ContactAddress->read(null, $id));
	}

	function add() {
		if (!empty($this->request->data)) {
			$this->ContactAddress->create();
			if ($this->ContactAddress->save($this->request->data)) {
				$this->Session->setFlash(__('The contact address has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The contact address could not be saved. Please, try again.', true));
			}
		}
		$contactAddressTypes = $this->ContactAddress->ContactAddressType->find('list');
		$contacts = $this->ContactAddress->Contact->find('list');
		$this->set(compact('contactAddressTypes', 'contacts'));
	}

	function edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid contact address', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->ContactAddress->save($this->request->data)) {
				$this->Session->setFlash(__('The contact address has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The contact address could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->ContactAddress->read(null, $id);
		}
		$contactAddressTypes = $this->ContactAddress->ContactAddressType->find('list');
		$contacts = $this->ContactAddress->Contact->find('list');
		$this->set(compact('contactAddressTypes', 'contacts'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for contact address', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->ContactAddress->delete($id)) {
			$this->Session->setFlash(__('Contact address deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Contact address was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>
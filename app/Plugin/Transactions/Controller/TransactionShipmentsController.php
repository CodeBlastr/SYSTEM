<?php
App::uses('TransactionsAppController', 'Transactions.Controller');
/**
 * TransactionShipments Controller
 *
 * @property TransactionShipment $TransactionShipment
 */
class TransactionShipmentsController extends TransactionsAppController {


/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->TransactionShipment->recursive = 0;
		$this->set('transactionShipments', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->TransactionShipment->id = $id;
		if (!$this->TransactionShipment->exists()) {
			throw new NotFoundException(__('Invalid transaction shipment'));
		}
		$this->set('transactionShipment', $this->TransactionShipment->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->TransactionShipment->create();
			if ($this->TransactionShipment->save($this->request->data)) {
				$this->Session->setFlash(__('The transaction shipment has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The transaction shipment could not be saved. Please, try again.'));
			}
		}
		$transactions = $this->TransactionShipment->Transaction->find('list');
		$users = $this->TransactionShipment->User->find('list');
		$this->set(compact('transactions', 'users'));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->TransactionShipment->id = $id;
		if (!$this->TransactionShipment->exists()) {
			throw new NotFoundException(__('Invalid transaction shipment'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->TransactionShipment->save($this->request->data)) {
				$this->Session->setFlash(__('The transaction shipment has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The transaction shipment could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->TransactionShipment->read(null, $id);
		}
		$transactions = $this->TransactionShipment->Transaction->find('list');
		$users = $this->TransactionShipment->User->find('list');
		$this->set(compact('transactions', 'users'));
	}

/**
 * delete method
 *
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->TransactionShipment->id = $id;
		if (!$this->TransactionShipment->exists()) {
			throw new NotFoundException(__('Invalid transaction shipment'));
		}
		if ($this->TransactionShipment->delete()) {
			$this->Session->setFlash(__('Transaction shipment deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Transaction shipment was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}

<?php
App::uses('TransactionsAppController', 'Transactions.Controller');
/**
 * TransactionPayments Controller
 *
 * @property TransactionPayment $TransactionPayment
 */
class TransactionPaymentsController extends TransactionsAppController {

    	public	$name = 'TransactionPayments';
	public	$uses = array('Transactions.TransactionPayments');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->TransactionPayment->recursive = 0;
		$this->set('transactionPayments', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->TransactionPayment->id = $id;
		if (!$this->TransactionPayment->exists()) {
			throw new NotFoundException(__('Invalid transaction payment'));
		}
		$this->set('transactionPayment', $this->TransactionPayment->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->TransactionPayment->create();
			if ($this->TransactionPayment->save($this->request->data)) {
				$this->Session->setFlash(__('The transaction payment has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The transaction payment could not be saved. Please, try again.'));
			}
		}
		$transactions = $this->TransactionPayment->Transaction->find('list');
		$users = $this->TransactionPayment->User->find('list');
		$this->set(compact('transactions', 'users'));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->TransactionPayment->id = $id;
		if (!$this->TransactionPayment->exists()) {
			throw new NotFoundException(__('Invalid transaction payment'));
		}
		if ( ($this->request->is('post') || $this->request->is('put')) && !empty($this->request->data)) {
			if ($this->TransactionPayment->save($this->request->data)) {
				$this->Session->setFlash(__('The transaction payment has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The transaction payment could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->TransactionPayment->read(null, $id);
		}
		$transactions = $this->TransactionPayment->Transaction->find('list');
		$users = $this->TransactionPayment->User->find('list');
		$cimProfiles = $this->TransactionPayment->CimProfile->find('list');
		$cimPaymentProfiles = $this->TransactionPayment->CimPaymentProfile->find('list');
		$this->set(compact('transactions', 'users', 'cimProfiles', 'cimPaymentProfiles'));
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
		$this->TransactionPayment->id = $id;
		if (!$this->TransactionPayment->exists()) {
			throw new NotFoundException(__('Invalid transaction payment'));
		}
		if ($this->TransactionPayment->delete()) {
			$this->Session->setFlash(__('Transaction payment deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Transaction payment was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}

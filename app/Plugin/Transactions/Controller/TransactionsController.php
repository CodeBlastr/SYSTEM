<?php
App::uses('TransactionsAppController', 'Transactions.Controller');
/**
 * Transactions Controller
 *
 * @property Transaction $Transaction
 */
class TransactionsController extends TransactionsAppController {

	public $name = 'Transactions';
	
	public $uses = array('Transactions.Transaction');
	
/**
 * checkout method
 * processes the order and payment
 *
 * @return void
 */
	public function checkout() {
	    if($this->request->data) {
		// get their official Transaction
		$officalTransaction = $this->Transaction->finalizeTransaction($this->Session->read('Auth.User.id'));

		// process the payment

		// if error with payment, return them to /myCart

		// else redirect them to success page

	    } else {
		$this->Session->setFlash('Invalid transaction.');
		$this->redirect($this->referer());
	    }
	}
	
/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Transaction->recursive = 0;
		$this->set('transactions', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Transaction->id = $id;
		if (!$this->Transaction->exists()) {
			throw new NotFoundException(__('Invalid transaction'));
		}
		$this->set('transaction', $this->Transaction->read(null, $id));
	}
	public function myCart() {
	    	// ensure that SSL is on if it's supposed to be
		if (defined('__ORDERS_SSL') && !strpos($_SERVER['HTTP_HOST'], 'localhost')) : $this->Ssl->force(); endif;
		
		// get their cart and process it
		$myCart = $this->Transaction->processCart($this->Session->read('Auth.User.id'));
		
		if (!$myCart) {
			throw new NotFoundException(__('Invalid transaction'));
		}
		
		// gather checkout options like shipping, payments, etc
		$options = $this->Transaction->gatherCheckoutOptions();
		
		// display their cart
		$this->set(compact('myCart', 'options'));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Transaction->create();
			if ($this->Transaction->save($this->request->data)) {
				$this->Session->setFlash(__('The transaction has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The transaction could not be saved. Please, try again.'));
			}
		}
		$transactionPayments = $this->Transaction->TransactionPayment->find('list');
		$transactionShipments = $this->Transaction->TransactionShipment->find('list');
		$transactionCoupons = $this->Transaction->TransactionCoupon->find('list');
		$customers = $this->Transaction->Customer->find('list');
		$contacts = $this->Transaction->Contact->find('list');
		$assignees = $this->Transaction->Assignee->find('list');
		$this->set(compact('transactionPayments', 'transactionShipments', 'transactionCoupons', 'customers', 'contacts', 'assignees'));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Transaction->id = $id;
		if (!$this->Transaction->exists()) {
			throw new NotFoundException(__('Invalid transaction'));
		}
		if ( ($this->request->is('post') || $this->request->is('put')) && !empty($this->request->data)) {
			if ($this->Transaction->save($this->request->data)) {
				$this->Session->setFlash(__('The transaction has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The transaction could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Transaction->read(null, $id);
		}
		$transactionPayments = $this->Transaction->TransactionPayment->find('list');
		$transactionShipments = $this->Transaction->TransactionShipment->find('list');
		$transactionCoupons = $this->Transaction->TransactionCoupon->find('list');
		$customers = $this->Transaction->Customer->find('list');
		$contacts = $this->Transaction->Contact->find('list');
		$assignees = $this->Transaction->Assignee->find('list');
		$this->set(compact('transactionPayments', 'transactionShipments', 'transactionCoupons', 'customers', 'contacts', 'assignees'));
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
		$this->Transaction->id = $id;
		if (!$this->Transaction->exists()) {
			throw new NotFoundException(__('Invalid transaction'));
		}
		if ($this->Transaction->delete()) {
			$this->Session->setFlash(__('Transaction deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Transaction was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}

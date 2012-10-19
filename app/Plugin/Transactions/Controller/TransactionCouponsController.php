<?php
App::uses('TransactionsAppController', 'Transactions.Controller');
/**
 * TransactionCoupons Controller
 *
 * @property TransactionCoupon $TransactionCoupon
 */
class TransactionCouponsController extends TransactionsAppController {


/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->TransactionCoupon->recursive = 0;
		$this->set('transactionCoupons', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->TransactionCoupon->id = $id;
		if (!$this->TransactionCoupon->exists()) {
			throw new NotFoundException(__('Invalid transaction coupon'));
		}
		$this->set('transactionCoupon', $this->TransactionCoupon->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->TransactionCoupon->create();
			if ($this->TransactionCoupon->save($this->request->data)) {
				$this->Session->setFlash(__('The transaction coupon has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The transaction coupon could not be saved. Please, try again.'));
			}
		}
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->TransactionCoupon->id = $id;
		if (!$this->TransactionCoupon->exists()) {
			throw new NotFoundException(__('Invalid transaction coupon'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->TransactionCoupon->save($this->request->data)) {
				$this->Session->setFlash(__('The transaction coupon has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The transaction coupon could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->TransactionCoupon->read(null, $id);
		}
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
		$this->TransactionCoupon->id = $id;
		if (!$this->TransactionCoupon->exists()) {
			throw new NotFoundException(__('Invalid transaction coupon'));
		}
		if ($this->TransactionCoupon->delete()) {
			$this->Session->setFlash(__('Transaction coupon deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Transaction coupon was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}

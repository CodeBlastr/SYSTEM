<?php
App::uses('TransactionsAppController', 'Transactions.Controller');
/**
 * TransactionItems Controller
 *
 * @property TransactionItem $TransactionItem
 */
class TransactionItemsController extends TransactionsAppController {

	public	$name = 'TransactionItems';
	public	$uses = array('Transactions.TransactionItem');


/**
 * index method
 *
 * @return void
 */
	public function index() {
		//$this->TransactionItem->recursive = 0;
		$this->set('transactionItems', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->TransactionItem->id = $id;
		if (!$this->TransactionItem->exists()) {
			throw new NotFoundException(__('Invalid transaction item'));
		}
		$this->set('transactionItem', $this->TransactionItem->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
		    
			// set a transaction id (cart id) for this user
			$this->TransactionItem->Transaction->id = $this->TransactionItem->setCartId();
			
			/** @todo check stock and cart max **/
			$isAddable = $this->TransactionItem->verifyItemRequest($this->request->data);
			
			// create the item internally
			$itemData = $this->TransactionItem->mapItemData($this->request->data);
			$this->TransactionItem->create($itemData);
			
			// It puts the item in the cart.
			if ($this->TransactionItem->save($this->request->data)) {
				$this->Session->setFlash(__('The transaction item has been saved'));
				$this->redirect(array('plugin'=>'transactions', 'controller'=>'transactions', 'action'=>'myCart'));
			} else {
				$this->Session->setFlash(__('The transaction item could not be saved. Please, try again.'));
				$this->redirect($this->referer());
			}
		} else {
		    throw new NotFoundException(__('Invalid transaction request'));
		}
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->TransactionItem->id = $id;
		if (!$this->TransactionItem->exists()) {
			throw new NotFoundException(__('Invalid transaction item'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->TransactionItem->save($this->request->data)) {
				$this->Session->setFlash(__('The transaction item has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The transaction item could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->TransactionItem->read(null, $id);
		}
		$catalogItems = $this->TransactionItem->CatalogItem->find('list');
		$transactionPayments = $this->TransactionItem->TransactionPayment->find('list');
		$transactionShipments = $this->TransactionItem->TransactionShipment->find('list');
		$transactions = $this->TransactionItem->Transaction->find('list');
		$customers = $this->TransactionItem->Customer->find('list');
		$contacts = $this->TransactionItem->Contact->find('list');
		$assignees = $this->TransactionItem->Assignee->find('list');
		$creators = $this->TransactionItem->Creator->find('list');
		$modifiers = $this->TransactionItem->Modifier->find('list');
		$this->set(compact('catalogItems', 'transactionPayments', 'transactionShipments', 'transactions', 'customers', 'contacts', 'assignees', 'creators', 'modifiers'));
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
		$this->TransactionItem->id = $id;
		if (!$this->TransactionItem->exists()) {
			throw new NotFoundException(__('Invalid transaction item'));
		}
		if ($this->TransactionItem->delete()) {
			$this->Session->setFlash(__('Transaction item deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Transaction item was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}

<?php
App::uses('TransactionsController', 'Transactions.Controller');
/**
 * @see <http://book.cakephp.org/2.0/en/development/testing.html#testing-controllers>
 */
class TransactionModel extends CakeTestModel {

/**
 * useTable
 *
 * @var string
 */
	public $useTable = 'transactions';
}

/**
 * TestTransactionsController *
 */
class TestTransactionsController extends TransactionsController {
/**
 * Auto render
 *
 * @var boolean
 */
	public $autoRender = false;

/**
 * Redirect action
 *
 * @param mixed $url
 * @param mixed $status
 * @param boolean $exit
 * @return void
 */
	public function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

/**
 * TransactionsController Test Case
 *
 */
class TransactionsControllerTestCase extends ControllerTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('transactions.transaction', 'users.user', 'transactions.transaction_payment', 'transactions.transaction_item', 'transactions.transaction_shipment', 'users.customer', 'users.contact', 'users.assignee', 'users.creator', 'users.modifier', 'transactions.transaction_coupon', 'conditions.condition');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Transactions = new TestTransactionsController();
		$this->Transactions->constructClasses();
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Transactions);

		parent::tearDown();
	}

/**
 * testCheckout method
 *
 * @return void
 */
	public function testCheckout() {
	    $result = $this->testAction('/transactions/transactions/checkout');
	    debug($result);
	}
/**
 * testIndex method
 *
 * @return void
 */
	public function testIndex() {
	    $result = $this->testAction('/transactions/transactions/index');
	    debug($result);
	}
/**
 * testView method
 *
 * @return void
 */
	public function testView() {

	}
/**
 * testAdd method
 *
 * @return void
 */
	public function testAdd() {
	    $result = $this->testAction('/transactions/transactions/add');
	    debug($result);
	}
/**
 * testEdit method
 *
 * @return void
 */
	public function testReqestingBadEditUrl() {
	    try {
		$result = $this->testAction('/transactions/transactions/edit');
		debug($result);
	    } catch (Exception $e) {}
	}
	
	public function testReqestingGoodEditUrl() {
	    $random = $this->Transactions->Transaction->find('first');
	    $result = $this->testAction('/transactions/transactions/edit/'.$random['Transaction']['id']);
	    debug($result);
	}
	
	public function testEditingWithGoodData() {
	    $random = $this->Transactions->Transaction->find('first');
	    $result = $this->testAction('/transactions/transactions/edit/'.$random['Transaction']['id'], array('data' => $random, 'method' => 'post'));
	    debug($result);
	}
/**
 * testDelete method
 *
 * @return void
 */
	public function testDelete() {

	}
}

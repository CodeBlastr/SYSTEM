<?php
App::uses('TransactionPaymentsController', 'Transactions.Controller');

/**
 * TestTransactionPaymentsController *
 */
class TestTransactionPaymentsController extends TransactionPaymentsController {
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
 * TransactionPaymentsController Test Case
 *
 */
class TransactionPaymentsControllerTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('transactions.transaction_payment', 'transactions.transaction', 'transactions.transaction_shipment', 'users.user', 'transactions.transaction_item', 'user.customer', 'contacts.contact', 'user.assignee', 'user.creator', 'user.modifier', 'transactions.transaction_coupon', 'conditions.condition');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->TransactionPayments = new TestTransactionPaymentsController();
		$this->TransactionPayments->constructClasses();
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->TransactionPayments);

		parent::tearDown();
	}

/**
 * testIndex method
 *
 * @return void
 */
	public function testIndex() {

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

	}
/**
 * testEdit method
 *
 * @return void
 */
	public function testEdit() {

	}
/**
 * testDelete method
 *
 * @return void
 */
	public function testDelete() {

	}
}

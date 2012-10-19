<?php
App::uses('TransactionCouponsController', 'Controller');

/**
 * TestTransactionCouponsController *
 */
class TestTransactionCouponsController extends TransactionCouponsController {
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
 * TransactionCouponsController Test Case
 *
 */
class TransactionCouponsControllerTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.transaction_coupon', 'app.transaction', 'app.transaction_payment', 'app.user', 'app.cim_profile', 'app.cim_payment_profile', 'app.transaction_item', 'app.catalog_item', 'app.transaction_shipment', 'app.customer', 'app.contact', 'app.assignee', 'app.creator', 'app.modifier', 'app.condition');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->TransactionCoupons = new TestTransactionCouponsController();
		$this->TransactionCoupons->constructClasses();
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->TransactionCoupons);

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

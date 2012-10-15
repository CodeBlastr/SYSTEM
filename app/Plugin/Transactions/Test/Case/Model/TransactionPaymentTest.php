<?php
App::uses('TransactionPayment', 'Model');

/**
 * TransactionPayment Test Case
 *
 */
class TransactionPaymentTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.transaction_payment', 'app.transaction', 'app.user', 'app.cim_profile', 'app.cim_payment_profile', 'app.transaction_item', 'app.catalog_item', 'app.transaction_shipment', 'app.customer', 'app.contact', 'app.assignee', 'app.creator', 'app.modifier');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->TransactionPayment = ClassRegistry::init('TransactionPayment');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->TransactionPayment);

		parent::tearDown();
	}

}

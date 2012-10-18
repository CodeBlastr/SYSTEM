<?php
App::uses('TransactionShipping', 'Model');

/**
 * Transaction Test Case
 *
 */
class TransactionShippingTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('transactions.transaction', 'transactions.transaction_payment', 'users.user', 'transactions.transaction_item', 'transactions.transaction_shipment', 'users.customer', 'contacts.contact', 'users.assignee', 'users.creator', 'users.modifier', 'transactions.transaction_coupon');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Transaction = ClassRegistry::init('TransactionShipping');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Transaction);

		parent::tearDown();
	}

}

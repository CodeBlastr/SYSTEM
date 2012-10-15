<?php
App::uses('TransactionCoupon', 'Model');

/**
 * TransactionCoupon Test Case
 *
 */
class TransactionCouponTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.transaction_coupon', 'app.transaction');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->TransactionCoupon = ClassRegistry::init('TransactionCoupon');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->TransactionCoupon);

		parent::tearDown();
	}

}

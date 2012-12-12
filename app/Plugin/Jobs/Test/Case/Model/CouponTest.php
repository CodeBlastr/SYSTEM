<?php
App::uses('Coupon', 'Coupons.Model');


/**
 * Coupon Test Case
 *
 */

class CouponTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.Condition','plugin.Coupons.Coupon');


/**
* setUp method
*
* @return void
*/
	public function setUp() {
		parent::setUp();
		$this->Coupon = ClassRegistry::init('Coupons.Coupon');
	}

	
/**
* tearDown method
*
* @return void
*/
	public function tearDown() {
		unset($this->Coupon);

		parent::tearDown();
	}







}

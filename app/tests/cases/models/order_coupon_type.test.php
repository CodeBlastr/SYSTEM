<?php 
/* SVN FILE: $Id$ */
/* OrderCouponType Test cases generated on: 2009-12-14 00:52:04 : 1260769924*/
App::import('Model', 'OrderCouponType');

class OrderCouponTypeTestCase extends CakeTestCase {
	var $OrderCouponType = null;
	var $fixtures = array('app.order_coupon_type', 'app.order_coupon');

	function startTest() {
		$this->OrderCouponType =& ClassRegistry::init('OrderCouponType');
	}

	function testOrderCouponTypeInstance() {
		$this->assertTrue(is_a($this->OrderCouponType, 'OrderCouponType'));
	}

	function testOrderCouponTypeFind() {
		$this->OrderCouponType->recursive = -1;
		$results = $this->OrderCouponType->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('OrderCouponType' => array(
			'id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'created'  => '2009-12-14 00:52:04',
			'modified'  => '2009-12-14 00:52:04'
		));
		$this->assertEqual($results, $expected);
	}
}
?>
<?php 
/* SVN FILE: $Id$ */
/* OrderCoupon Test cases generated on: 2009-12-14 00:52:22 : 1260769942*/
App::import('Model', 'OrderCoupon');

class OrderCouponTestCase extends CakeTestCase {
	var $OrderCoupon = null;
	var $fixtures = array('app.order_coupon', 'app.order_coupon_type', 'app.user');

	function startTest() {
		$this->OrderCoupon =& ClassRegistry::init('OrderCoupon');
	}

	function testOrderCouponInstance() {
		$this->assertTrue(is_a($this->OrderCoupon, 'OrderCoupon'));
	}

	function testOrderCouponFind() {
		$this->OrderCoupon->recursive = -1;
		$results = $this->OrderCoupon->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('OrderCoupon' => array(
			'id'  => 1,
			'order_coupon_type_id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'discount'  => 'Lorem ipsum dolor sit amet',
			'description'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'code'  => 'Lorem ipsum dolor sit amet',
			'start_date'  => '2009-12-14 00:52:22',
			'end_date'  => '2009-12-14 00:52:22',
			'published'  => 1,
			'user_id'  => 1,
			'created'  => '2009-12-14 00:52:22',
			'modified'  => '2009-12-14 00:52:22'
		));
		$this->assertEqual($results, $expected);
	}
}
?>
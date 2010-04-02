<?php 
/* SVN FILE: $Id$ */
/* OrderCouponsController Test cases generated on: 2009-12-13 23:38:41 : 1260765521*/
App::import('Controller', 'OrderCoupons');

class TestOrderCoupons extends OrderCouponsController {
	var $autoRender = false;
}

class OrderCouponsControllerTest extends CakeTestCase {
	var $OrderCoupons = null;

	function startTest() {
		$this->OrderCoupons = new TestOrderCoupons();
		$this->OrderCoupons->constructClasses();
	}

	function testOrderCouponsControllerInstance() {
		$this->assertTrue(is_a($this->OrderCoupons, 'OrderCouponsController'));
	}

	function endTest() {
		unset($this->OrderCoupons);
	}
}
?>
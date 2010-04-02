<?php 
/* SVN FILE: $Id$ */
/* OrderCouponTypesController Test cases generated on: 2009-12-13 23:38:46 : 1260765526*/
App::import('Controller', 'OrderCouponTypes');

class TestOrderCouponTypes extends OrderCouponTypesController {
	var $autoRender = false;
}

class OrderCouponTypesControllerTest extends CakeTestCase {
	var $OrderCouponTypes = null;

	function startTest() {
		$this->OrderCouponTypes = new TestOrderCouponTypes();
		$this->OrderCouponTypes->constructClasses();
	}

	function testOrderCouponTypesControllerInstance() {
		$this->assertTrue(is_a($this->OrderCouponTypes, 'OrderCouponTypesController'));
	}

	function endTest() {
		unset($this->OrderCouponTypes);
	}
}
?>
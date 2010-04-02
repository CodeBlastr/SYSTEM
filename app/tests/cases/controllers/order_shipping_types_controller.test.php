<?php 
/* SVN FILE: $Id$ */
/* OrderShippingTypesController Test cases generated on: 2009-12-13 23:39:18 : 1260765558*/
App::import('Controller', 'OrderShippingTypes');

class TestOrderShippingTypes extends OrderShippingTypesController {
	var $autoRender = false;
}

class OrderShippingTypesControllerTest extends CakeTestCase {
	var $OrderShippingTypes = null;

	function startTest() {
		$this->OrderShippingTypes = new TestOrderShippingTypes();
		$this->OrderShippingTypes->constructClasses();
	}

	function testOrderShippingTypesControllerInstance() {
		$this->assertTrue(is_a($this->OrderShippingTypes, 'OrderShippingTypesController'));
	}

	function endTest() {
		unset($this->OrderShippingTypes);
	}
}
?>
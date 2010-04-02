<?php 
/* SVN FILE: $Id$ */
/* OrderPaymentTypesController Test cases generated on: 2009-12-13 23:39:09 : 1260765549*/
App::import('Controller', 'OrderPaymentTypes');

class TestOrderPaymentTypes extends OrderPaymentTypesController {
	var $autoRender = false;
}

class OrderPaymentTypesControllerTest extends CakeTestCase {
	var $OrderPaymentTypes = null;

	function startTest() {
		$this->OrderPaymentTypes = new TestOrderPaymentTypes();
		$this->OrderPaymentTypes->constructClasses();
	}

	function testOrderPaymentTypesControllerInstance() {
		$this->assertTrue(is_a($this->OrderPaymentTypes, 'OrderPaymentTypesController'));
	}

	function endTest() {
		unset($this->OrderPaymentTypes);
	}
}
?>
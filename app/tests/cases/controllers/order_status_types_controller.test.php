<?php 
/* SVN FILE: $Id$ */
/* OrderStatusTypesController Test cases generated on: 2009-12-13 23:39:26 : 1260765566*/
App::import('Controller', 'OrderStatusTypes');

class TestOrderStatusTypes extends OrderStatusTypesController {
	var $autoRender = false;
}

class OrderStatusTypesControllerTest extends CakeTestCase {
	var $OrderStatusTypes = null;

	function startTest() {
		$this->OrderStatusTypes = new TestOrderStatusTypes();
		$this->OrderStatusTypes->constructClasses();
	}

	function testOrderStatusTypesControllerInstance() {
		$this->assertTrue(is_a($this->OrderStatusTypes, 'OrderStatusTypesController'));
	}

	function endTest() {
		unset($this->OrderStatusTypes);
	}
}
?>
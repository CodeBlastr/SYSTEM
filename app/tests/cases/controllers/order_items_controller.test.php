<?php 
/* SVN FILE: $Id$ */
/* OrderItemsController Test cases generated on: 2009-12-13 23:38:50 : 1260765530*/
App::import('Controller', 'OrderItems');

class TestOrderItems extends OrderItemsController {
	var $autoRender = false;
}

class OrderItemsControllerTest extends CakeTestCase {
	var $OrderItems = null;

	function startTest() {
		$this->OrderItems = new TestOrderItems();
		$this->OrderItems->constructClasses();
	}

	function testOrderItemsControllerInstance() {
		$this->assertTrue(is_a($this->OrderItems, 'OrderItemsController'));
	}

	function endTest() {
		unset($this->OrderItems);
	}
}
?>
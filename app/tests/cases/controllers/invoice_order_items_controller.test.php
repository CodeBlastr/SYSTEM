<?php 
/* SVN FILE: $Id$ */
/* InvoiceOrderItemsController Test cases generated on: 2009-12-13 23:37:55 : 1260765475*/
App::import('Controller', 'InvoiceOrderItems');

class TestInvoiceOrderItems extends InvoiceOrderItemsController {
	var $autoRender = false;
}

class InvoiceOrderItemsControllerTest extends CakeTestCase {
	var $InvoiceOrderItems = null;

	function startTest() {
		$this->InvoiceOrderItems = new TestInvoiceOrderItems();
		$this->InvoiceOrderItems->constructClasses();
	}

	function testInvoiceOrderItemsControllerInstance() {
		$this->assertTrue(is_a($this->InvoiceOrderItems, 'InvoiceOrderItemsController'));
	}

	function endTest() {
		unset($this->InvoiceOrderItems);
	}
}
?>
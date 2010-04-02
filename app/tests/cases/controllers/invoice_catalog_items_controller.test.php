<?php 
/* SVN FILE: $Id$ */
/* InvoiceCatalogItemsController Test cases generated on: 2009-12-13 23:37:50 : 1260765470*/
App::import('Controller', 'InvoiceCatalogItems');

class TestInvoiceCatalogItems extends InvoiceCatalogItemsController {
	var $autoRender = false;
}

class InvoiceCatalogItemsControllerTest extends CakeTestCase {
	var $InvoiceCatalogItems = null;

	function startTest() {
		$this->InvoiceCatalogItems = new TestInvoiceCatalogItems();
		$this->InvoiceCatalogItems->constructClasses();
	}

	function testInvoiceCatalogItemsControllerInstance() {
		$this->assertTrue(is_a($this->InvoiceCatalogItems, 'InvoiceCatalogItemsController'));
	}

	function endTest() {
		unset($this->InvoiceCatalogItems);
	}
}
?>
<?php 
/* SVN FILE: $Id$ */
/* InvoiceTimesheetItemsController Test cases generated on: 2009-12-13 23:38:06 : 1260765486*/
App::import('Controller', 'InvoiceTimesheetItems');

class TestInvoiceTimesheetItems extends InvoiceTimesheetItemsController {
	var $autoRender = false;
}

class InvoiceTimesheetItemsControllerTest extends CakeTestCase {
	var $InvoiceTimesheetItems = null;

	function startTest() {
		$this->InvoiceTimesheetItems = new TestInvoiceTimesheetItems();
		$this->InvoiceTimesheetItems->constructClasses();
	}

	function testInvoiceTimesheetItemsControllerInstance() {
		$this->assertTrue(is_a($this->InvoiceTimesheetItems, 'InvoiceTimesheetItemsController'));
	}

	function endTest() {
		unset($this->InvoiceTimesheetItems);
	}
}
?>
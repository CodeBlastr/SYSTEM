<?php 
/* SVN FILE: $Id$ */
/* InvoicesController Test cases generated on: 2009-12-13 23:37:45 : 1260765465*/
App::import('Controller', 'Invoices');

class TestInvoices extends InvoicesController {
	var $autoRender = false;
}

class InvoicesControllerTest extends CakeTestCase {
	var $Invoices = null;

	function startTest() {
		$this->Invoices = new TestInvoices();
		$this->Invoices->constructClasses();
	}

	function testInvoicesControllerInstance() {
		$this->assertTrue(is_a($this->Invoices, 'InvoicesController'));
	}

	function endTest() {
		unset($this->Invoices);
	}
}
?>
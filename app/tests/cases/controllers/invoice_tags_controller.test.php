<?php 
/* SVN FILE: $Id$ */
/* InvoiceTagsController Test cases generated on: 2009-12-13 23:38:01 : 1260765481*/
App::import('Controller', 'InvoiceTags');

class TestInvoiceTags extends InvoiceTagsController {
	var $autoRender = false;
}

class InvoiceTagsControllerTest extends CakeTestCase {
	var $InvoiceTags = null;

	function startTest() {
		$this->InvoiceTags = new TestInvoiceTags();
		$this->InvoiceTags->constructClasses();
	}

	function testInvoiceTagsControllerInstance() {
		$this->assertTrue(is_a($this->InvoiceTags, 'InvoiceTagsController'));
	}

	function endTest() {
		unset($this->InvoiceTags);
	}
}
?>
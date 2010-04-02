<?php 
/* SVN FILE: $Id$ */
/* InvoiceUserGroupsController Test cases generated on: 2009-12-13 23:38:12 : 1260765492*/
App::import('Controller', 'InvoiceUserGroups');

class TestInvoiceUserGroups extends InvoiceUserGroupsController {
	var $autoRender = false;
}

class InvoiceUserGroupsControllerTest extends CakeTestCase {
	var $InvoiceUserGroups = null;

	function startTest() {
		$this->InvoiceUserGroups = new TestInvoiceUserGroups();
		$this->InvoiceUserGroups->constructClasses();
	}

	function testInvoiceUserGroupsControllerInstance() {
		$this->assertTrue(is_a($this->InvoiceUserGroups, 'InvoiceUserGroupsController'));
	}

	function endTest() {
		unset($this->InvoiceUserGroups);
	}
}
?>
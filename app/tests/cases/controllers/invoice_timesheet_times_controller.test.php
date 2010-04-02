<?php 
/* SVN FILE: $Id$ */
/* InvoiceTimesheetTimesController Test cases generated on: 2010-01-01 10:06:41 : 1262358401*/
App::import('Controller', 'InvoiceTimesheetTimes');

class TestInvoiceTimesheetTimes extends InvoiceTimesheetTimesController {
	var $autoRender = false;
}

class InvoiceTimesheetTimesControllerTest extends CakeTestCase {
	var $InvoiceTimesheetTimes = null;

	function startTest() {
		$this->InvoiceTimesheetTimes = new TestInvoiceTimesheetTimes();
		$this->InvoiceTimesheetTimes->constructClasses();
	}

	function testInvoiceTimesheetTimesControllerInstance() {
		$this->assertTrue(is_a($this->InvoiceTimesheetTimes, 'InvoiceTimesheetTimesController'));
	}

	function endTest() {
		unset($this->InvoiceTimesheetTimes);
	}
}
?>
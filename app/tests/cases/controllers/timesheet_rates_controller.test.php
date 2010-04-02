<?php 
/* SVN FILE: $Id$ */
/* TimesheetRatesController Test cases generated on: 2009-12-13 23:42:04 : 1260765724*/
App::import('Controller', 'TimesheetRates');

class TestTimesheetRates extends TimesheetRatesController {
	var $autoRender = false;
}

class TimesheetRatesControllerTest extends CakeTestCase {
	var $TimesheetRates = null;

	function startTest() {
		$this->TimesheetRates = new TestTimesheetRates();
		$this->TimesheetRates->constructClasses();
	}

	function testTimesheetRatesControllerInstance() {
		$this->assertTrue(is_a($this->TimesheetRates, 'TimesheetRatesController'));
	}

	function endTest() {
		unset($this->TimesheetRates);
	}
}
?>
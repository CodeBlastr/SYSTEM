<?php 
/* SVN FILE: $Id$ */
/* TimesheetTimesController Test cases generated on: 2010-01-01 20:51:20 : 1262397080*/
App::import('Controller', 'TimesheetTimes');

class TestTimesheetTimes extends TimesheetTimesController {
	var $autoRender = false;
}

class TimesheetTimesControllerTest extends CakeTestCase {
	var $TimesheetTimes = null;

	function startTest() {
		$this->TimesheetTimes = new TestTimesheetTimes();
		$this->TimesheetTimes->constructClasses();
	}

	function testTimesheetTimesControllerInstance() {
		$this->assertTrue(is_a($this->TimesheetTimes, 'TimesheetTimesController'));
	}

	function endTest() {
		unset($this->TimesheetTimes);
	}
}
?>
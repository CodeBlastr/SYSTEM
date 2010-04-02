<?php 
/* SVN FILE: $Id$ */
/* TimesheetsController Test cases generated on: 2010-01-01 20:50:54 : 1262397054*/
App::import('Controller', 'Timesheets');

class TestTimesheets extends TimesheetsController {
	var $autoRender = false;
}

class TimesheetsControllerTest extends CakeTestCase {
	var $Timesheets = null;

	function startTest() {
		$this->Timesheets = new TestTimesheets();
		$this->Timesheets->constructClasses();
	}

	function testTimesheetsControllerInstance() {
		$this->assertTrue(is_a($this->Timesheets, 'TimesheetsController'));
	}

	function endTest() {
		unset($this->Timesheets);
	}
}
?>
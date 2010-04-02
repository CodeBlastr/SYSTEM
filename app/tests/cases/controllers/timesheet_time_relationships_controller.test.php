<?php 
/* SVN FILE: $Id$ */
/* TimesheetTimeRelationshipsController Test cases generated on: 2010-01-03 00:00:44 : 1262494844*/
App::import('Controller', 'TimesheetTimeRelationships');

class TestTimesheetTimeRelationships extends TimesheetTimeRelationshipsController {
	var $autoRender = false;
}

class TimesheetTimeRelationshipsControllerTest extends CakeTestCase {
	var $TimesheetTimeRelationships = null;

	function startTest() {
		$this->TimesheetTimeRelationships = new TestTimesheetTimeRelationships();
		$this->TimesheetTimeRelationships->constructClasses();
	}

	function testTimesheetTimeRelationshipsControllerInstance() {
		$this->assertTrue(is_a($this->TimesheetTimeRelationships, 'TimesheetTimeRelationshipsController'));
	}

	function endTest() {
		unset($this->TimesheetTimeRelationships);
	}
}
?>
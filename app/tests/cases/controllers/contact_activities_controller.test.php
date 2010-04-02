<?php 
/* SVN FILE: $Id$ */
/* ContactActivitiesController Test cases generated on: 2009-12-22 23:56:11 : 1261544171*/
App::import('Controller', 'ContactActivities');

class TestContactActivities extends ContactActivitiesController {
	var $autoRender = false;
}

class ContactActivitiesControllerTest extends CakeTestCase {
	var $ContactActivities = null;

	function startTest() {
		$this->ContactActivities = new TestContactActivities();
		$this->ContactActivities->constructClasses();
	}

	function testContactActivitiesControllerInstance() {
		$this->assertTrue(is_a($this->ContactActivities, 'ContactActivitiesController'));
	}

	function endTest() {
		unset($this->ContactActivities);
	}
}
?>
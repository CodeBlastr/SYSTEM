<?php 
/* SVN FILE: $Id$ */
/* ProjectTrackersController Test cases generated on: 2009-12-13 23:40:19 : 1260765619*/
App::import('Controller', 'ProjectTrackers');

class TestProjectTrackers extends ProjectTrackersController {
	var $autoRender = false;
}

class ProjectTrackersControllerTest extends CakeTestCase {
	var $ProjectTrackers = null;

	function startTest() {
		$this->ProjectTrackers = new TestProjectTrackers();
		$this->ProjectTrackers->constructClasses();
	}

	function testProjectTrackersControllerInstance() {
		$this->assertTrue(is_a($this->ProjectTrackers, 'ProjectTrackersController'));
	}

	function endTest() {
		unset($this->ProjectTrackers);
	}
}
?>
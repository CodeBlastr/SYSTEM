<?php 
/* SVN FILE: $Id$ */
/* ProjectWatchersController Test cases generated on: 2009-12-13 23:40:30 : 1260765630*/
App::import('Controller', 'ProjectWatchers');

class TestProjectWatchers extends ProjectWatchersController {
	var $autoRender = false;
}

class ProjectWatchersControllerTest extends CakeTestCase {
	var $ProjectWatchers = null;

	function startTest() {
		$this->ProjectWatchers = new TestProjectWatchers();
		$this->ProjectWatchers->constructClasses();
	}

	function testProjectWatchersControllerInstance() {
		$this->assertTrue(is_a($this->ProjectWatchers, 'ProjectWatchersController'));
	}

	function endTest() {
		unset($this->ProjectWatchers);
	}
}
?>
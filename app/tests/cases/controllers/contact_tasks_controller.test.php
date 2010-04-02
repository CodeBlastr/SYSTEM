<?php 
/* SVN FILE: $Id$ */
/* ContactTasksController Test cases generated on: 2009-12-13 23:35:30 : 1260765330*/
App::import('Controller', 'ContactTasks');

class TestContactTasks extends ContactTasksController {
	var $autoRender = false;
}

class ContactTasksControllerTest extends CakeTestCase {
	var $ContactTasks = null;

	function startTest() {
		$this->ContactTasks = new TestContactTasks();
		$this->ContactTasks->constructClasses();
	}

	function testContactTasksControllerInstance() {
		$this->assertTrue(is_a($this->ContactTasks, 'ContactTasksController'));
	}

	function endTest() {
		unset($this->ContactTasks);
	}
}
?>
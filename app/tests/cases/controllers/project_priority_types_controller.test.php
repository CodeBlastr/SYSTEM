<?php 
/* SVN FILE: $Id$ */
/* ProjectPriorityTypesController Test cases generated on: 2009-12-13 23:39:53 : 1260765593*/
App::import('Controller', 'ProjectPriorityTypes');

class TestProjectPriorityTypes extends ProjectPriorityTypesController {
	var $autoRender = false;
}

class ProjectPriorityTypesControllerTest extends CakeTestCase {
	var $ProjectPriorityTypes = null;

	function startTest() {
		$this->ProjectPriorityTypes = new TestProjectPriorityTypes();
		$this->ProjectPriorityTypes->constructClasses();
	}

	function testProjectPriorityTypesControllerInstance() {
		$this->assertTrue(is_a($this->ProjectPriorityTypes, 'ProjectPriorityTypesController'));
	}

	function endTest() {
		unset($this->ProjectPriorityTypes);
	}
}
?>
<?php 
/* SVN FILE: $Id$ */
/* ProjectStatusTypesController Test cases generated on: 2009-12-13 23:39:59 : 1260765599*/
App::import('Controller', 'ProjectStatusTypes');

class TestProjectStatusTypes extends ProjectStatusTypesController {
	var $autoRender = false;
}

class ProjectStatusTypesControllerTest extends CakeTestCase {
	var $ProjectStatusTypes = null;

	function startTest() {
		$this->ProjectStatusTypes = new TestProjectStatusTypes();
		$this->ProjectStatusTypes->constructClasses();
	}

	function testProjectStatusTypesControllerInstance() {
		$this->assertTrue(is_a($this->ProjectStatusTypes, 'ProjectStatusTypesController'));
	}

	function endTest() {
		unset($this->ProjectStatusTypes);
	}
}
?>
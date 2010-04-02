<?php 
/* SVN FILE: $Id$ */
/* MediumTypesController Test cases generated on: 2009-12-13 23:38:27 : 1260765507*/
App::import('Controller', 'MediumTypes');

class TestMediumTypes extends MediumTypesController {
	var $autoRender = false;
}

class MediumTypesControllerTest extends CakeTestCase {
	var $MediumTypes = null;

	function startTest() {
		$this->MediumTypes = new TestMediumTypes();
		$this->MediumTypes->constructClasses();
	}

	function testMediumTypesControllerInstance() {
		$this->assertTrue(is_a($this->MediumTypes, 'MediumTypesController'));
	}

	function endTest() {
		unset($this->MediumTypes);
	}
}
?>
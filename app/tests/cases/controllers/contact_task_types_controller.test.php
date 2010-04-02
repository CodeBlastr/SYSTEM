<?php 
/* SVN FILE: $Id$ */
/* ContactTaskTypesController Test cases generated on: 2009-12-13 23:35:39 : 1260765339*/
App::import('Controller', 'ContactTaskTypes');

class TestContactTaskTypes extends ContactTaskTypesController {
	var $autoRender = false;
}

class ContactTaskTypesControllerTest extends CakeTestCase {
	var $ContactTaskTypes = null;

	function startTest() {
		$this->ContactTaskTypes = new TestContactTaskTypes();
		$this->ContactTaskTypes->constructClasses();
	}

	function testContactTaskTypesControllerInstance() {
		$this->assertTrue(is_a($this->ContactTaskTypes, 'ContactTaskTypesController'));
	}

	function endTest() {
		unset($this->ContactTaskTypes);
	}
}
?>
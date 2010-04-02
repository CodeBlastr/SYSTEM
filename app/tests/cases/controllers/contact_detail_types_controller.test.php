<?php 
/* SVN FILE: $Id$ */
/* ContactDetailTypesController Test cases generated on: 2009-12-13 23:34:44 : 1260765284*/
App::import('Controller', 'ContactDetailTypes');

class TestContactDetailTypes extends ContactDetailTypesController {
	var $autoRender = false;
}

class ContactDetailTypesControllerTest extends CakeTestCase {
	var $ContactDetailTypes = null;

	function startTest() {
		$this->ContactDetailTypes = new TestContactDetailTypes();
		$this->ContactDetailTypes->constructClasses();
	}

	function testContactDetailTypesControllerInstance() {
		$this->assertTrue(is_a($this->ContactDetailTypes, 'ContactDetailTypesController'));
	}

	function endTest() {
		unset($this->ContactDetailTypes);
	}
}
?>
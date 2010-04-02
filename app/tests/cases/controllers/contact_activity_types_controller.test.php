<?php 
/* SVN FILE: $Id$ */
/* ContactActivityTypesController Test cases generated on: 2009-12-23 07:54:29 : 1261572869*/
App::import('Controller', 'ContactActivityTypes');

class TestContactActivityTypes extends ContactActivityTypesController {
	var $autoRender = false;
}

class ContactActivityTypesControllerTest extends CakeTestCase {
	var $ContactActivityTypes = null;

	function startTest() {
		$this->ContactActivityTypes = new TestContactActivityTypes();
		$this->ContactActivityTypes->constructClasses();
	}

	function testContactActivityTypesControllerInstance() {
		$this->assertTrue(is_a($this->ContactActivityTypes, 'ContactActivityTypesController'));
	}

	function endTest() {
		unset($this->ContactActivityTypes);
	}
}
?>
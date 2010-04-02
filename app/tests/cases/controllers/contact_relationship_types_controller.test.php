<?php 
/* SVN FILE: $Id$ */
/* ContactRelationshipTypesController Test cases generated on: 2009-12-13 23:35:14 : 1260765314*/
App::import('Controller', 'ContactRelationshipTypes');

class TestContactRelationshipTypes extends ContactRelationshipTypesController {
	var $autoRender = false;
}

class ContactRelationshipTypesControllerTest extends CakeTestCase {
	var $ContactRelationshipTypes = null;

	function startTest() {
		$this->ContactRelationshipTypes = new TestContactRelationshipTypes();
		$this->ContactRelationshipTypes->constructClasses();
	}

	function testContactRelationshipTypesControllerInstance() {
		$this->assertTrue(is_a($this->ContactRelationshipTypes, 'ContactRelationshipTypesController'));
	}

	function endTest() {
		unset($this->ContactRelationshipTypes);
	}
}
?>
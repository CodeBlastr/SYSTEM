<?php 
/* SVN FILE: $Id$ */
/* ContactRelationshipsController Test cases generated on: 2009-12-13 23:35:09 : 1260765309*/
App::import('Controller', 'ContactRelationships');

class TestContactRelationships extends ContactRelationshipsController {
	var $autoRender = false;
}

class ContactRelationshipsControllerTest extends CakeTestCase {
	var $ContactRelationships = null;

	function startTest() {
		$this->ContactRelationships = new TestContactRelationships();
		$this->ContactRelationships->constructClasses();
	}

	function testContactRelationshipsControllerInstance() {
		$this->assertTrue(is_a($this->ContactRelationships, 'ContactRelationshipsController'));
	}

	function endTest() {
		unset($this->ContactRelationships);
	}
}
?>
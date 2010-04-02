<?php 
/* SVN FILE: $Id$ */
/* ContactPersonSalutationsController Test cases generated on: 2009-12-16 16:18:51 : 1260998331*/
App::import('Controller', 'ContactPersonSalutations');

class TestContactPersonSalutations extends ContactPersonSalutationsController {
	var $autoRender = false;
}

class ContactPersonSalutationsControllerTest extends CakeTestCase {
	var $ContactPersonSalutations = null;

	function startTest() {
		$this->ContactPersonSalutations = new TestContactPersonSalutations();
		$this->ContactPersonSalutations->constructClasses();
	}

	function testContactPersonSalutationsControllerInstance() {
		$this->assertTrue(is_a($this->ContactPersonSalutations, 'ContactPersonSalutationsController'));
	}

	function endTest() {
		unset($this->ContactPersonSalutations);
	}
}
?>
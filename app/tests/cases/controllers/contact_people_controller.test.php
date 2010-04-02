<?php 
/* SVN FILE: $Id$ */
/* ContactPeopleController Test cases generated on: 2009-12-14 21:03:12 : 1260842592*/
App::import('Controller', 'ContactPeople');

class TestContactPeople extends ContactPeopleController {
	var $autoRender = false;
}

class ContactPeopleControllerTest extends CakeTestCase {
	var $ContactPeople = null;

	function startTest() {
		$this->ContactPeople = new TestContactPeople();
		$this->ContactPeople->constructClasses();
	}

	function testContactPeopleControllerInstance() {
		$this->assertTrue(is_a($this->ContactPeople, 'ContactPeopleController'));
	}

	function endTest() {
		unset($this->ContactPeople);
	}
}
?>
<?php 
/* SVN FILE: $Id$ */
/* ContactUserGroupsController Test cases generated on: 2009-12-13 23:35:56 : 1260765356*/
App::import('Controller', 'ContactUserGroups');

class TestContactUserGroups extends ContactUserGroupsController {
	var $autoRender = false;
}

class ContactUserGroupsControllerTest extends CakeTestCase {
	var $ContactUserGroups = null;

	function startTest() {
		$this->ContactUserGroups = new TestContactUserGroups();
		$this->ContactUserGroups->constructClasses();
	}

	function testContactUserGroupsControllerInstance() {
		$this->assertTrue(is_a($this->ContactUserGroups, 'ContactUserGroupsController'));
	}

	function endTest() {
		unset($this->ContactUserGroups);
	}
}
?>
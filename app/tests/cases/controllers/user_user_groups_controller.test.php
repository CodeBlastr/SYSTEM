<?php 
/* SVN FILE: $Id$ */
/* UserUserGroupsController Test cases generated on: 2009-12-14 12:24:03 : 1260811443*/
App::import('Controller', 'UserUserGroups');

class TestUserUserGroups extends UserUserGroupsController {
	var $autoRender = false;
}

class UserUserGroupsControllerTest extends CakeTestCase {
	var $UserUserGroups = null;

	function startTest() {
		$this->UserUserGroups = new TestUserUserGroups();
		$this->UserUserGroups->constructClasses();
	}

	function testUserUserGroupsControllerInstance() {
		$this->assertTrue(is_a($this->UserUserGroups, 'UserUserGroupsController'));
	}

	function endTest() {
		unset($this->UserUserGroups);
	}
}
?>
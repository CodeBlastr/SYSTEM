<?php 
/* SVN FILE: $Id$ */
/* UserGroupsController Test cases generated on: 2010-01-03 13:22:09 : 1262542929*/
App::import('Controller', 'UserGroups');

class TestUserGroups extends UserGroupsController {
	var $autoRender = false;
}

class UserGroupsControllerTest extends CakeTestCase {
	var $UserGroups = null;

	function startTest() {
		$this->UserGroups = new TestUserGroups();
		$this->UserGroups->constructClasses();
	}

	function testUserGroupsControllerInstance() {
		$this->assertTrue(is_a($this->UserGroups, 'UserGroupsController'));
	}

	function endTest() {
		unset($this->UserGroups);
	}
}
?>
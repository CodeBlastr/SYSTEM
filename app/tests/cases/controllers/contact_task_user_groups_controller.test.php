<?php 
/* SVN FILE: $Id$ */
/* ContactTaskUserGroupsController Test cases generated on: 2009-12-13 23:35:44 : 1260765344*/
App::import('Controller', 'ContactTaskUserGroups');

class TestContactTaskUserGroups extends ContactTaskUserGroupsController {
	var $autoRender = false;
}

class ContactTaskUserGroupsControllerTest extends CakeTestCase {
	var $ContactTaskUserGroups = null;

	function startTest() {
		$this->ContactTaskUserGroups = new TestContactTaskUserGroups();
		$this->ContactTaskUserGroups->constructClasses();
	}

	function testContactTaskUserGroupsControllerInstance() {
		$this->assertTrue(is_a($this->ContactTaskUserGroups, 'ContactTaskUserGroupsController'));
	}

	function endTest() {
		unset($this->ContactTaskUserGroups);
	}
}
?>
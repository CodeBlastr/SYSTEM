<?php 
/* SVN FILE: $Id$ */
/* ContactActivityUserGroupsController Test cases generated on: 2009-12-13 23:34:00 : 1260765240*/
App::import('Controller', 'ContactActivityUserGroups');

class TestContactActivityUserGroups extends ContactActivityUserGroupsController {
	var $autoRender = false;
}

class ContactActivityUserGroupsControllerTest extends CakeTestCase {
	var $ContactActivityUserGroups = null;

	function startTest() {
		$this->ContactActivityUserGroups = new TestContactActivityUserGroups();
		$this->ContactActivityUserGroups->constructClasses();
	}

	function testContactActivityUserGroupsControllerInstance() {
		$this->assertTrue(is_a($this->ContactActivityUserGroups, 'ContactActivityUserGroupsController'));
	}

	function endTest() {
		unset($this->ContactActivityUserGroups);
	}
}
?>
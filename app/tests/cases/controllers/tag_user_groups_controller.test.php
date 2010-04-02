<?php 
/* SVN FILE: $Id$ */
/* TagUserGroupsController Test cases generated on: 2009-12-13 23:41:25 : 1260765685*/
App::import('Controller', 'TagUserGroups');

class TestTagUserGroups extends TagUserGroupsController {
	var $autoRender = false;
}

class TagUserGroupsControllerTest extends CakeTestCase {
	var $TagUserGroups = null;

	function startTest() {
		$this->TagUserGroups = new TestTagUserGroups();
		$this->TagUserGroups->constructClasses();
	}

	function testTagUserGroupsControllerInstance() {
		$this->assertTrue(is_a($this->TagUserGroups, 'TagUserGroupsController'));
	}

	function endTest() {
		unset($this->TagUserGroups);
	}
}
?>
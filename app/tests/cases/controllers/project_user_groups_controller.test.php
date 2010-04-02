<?php 
/* SVN FILE: $Id$ */
/* ProjectUserGroupsController Test cases generated on: 2009-12-13 23:40:24 : 1260765624*/
App::import('Controller', 'ProjectUserGroups');

class TestProjectUserGroups extends ProjectUserGroupsController {
	var $autoRender = false;
}

class ProjectUserGroupsControllerTest extends CakeTestCase {
	var $ProjectUserGroups = null;

	function startTest() {
		$this->ProjectUserGroups = new TestProjectUserGroups();
		$this->ProjectUserGroups->constructClasses();
	}

	function testProjectUserGroupsControllerInstance() {
		$this->assertTrue(is_a($this->ProjectUserGroups, 'ProjectUserGroupsController'));
	}

	function endTest() {
		unset($this->ProjectUserGroups);
	}
}
?>
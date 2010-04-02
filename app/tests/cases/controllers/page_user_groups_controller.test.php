<?php 
/* SVN FILE: $Id$ */
/* PageUserGroupsController Test cases generated on: 2009-12-13 23:49:24 : 1260766164*/
App::import('Controller', 'PageUserGroups');

class TestPageUserGroups extends PageUserGroupsController {
	var $autoRender = false;
}

class PageUserGroupsControllerTest extends CakeTestCase {
	var $PageUserGroups = null;

	function startTest() {
		$this->PageUserGroups = new TestPageUserGroups();
		$this->PageUserGroups->constructClasses();
	}

	function testPageUserGroupsControllerInstance() {
		$this->assertTrue(is_a($this->PageUserGroups, 'PageUserGroupsController'));
	}

	function endTest() {
		unset($this->PageUserGroups);
	}
}
?>
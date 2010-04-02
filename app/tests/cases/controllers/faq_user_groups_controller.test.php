<?php 
/* SVN FILE: $Id$ */
/* FaqUserGroupsController Test cases generated on: 2009-12-13 23:37:40 : 1260765460*/
App::import('Controller', 'FaqUserGroups');

class TestFaqUserGroups extends FaqUserGroupsController {
	var $autoRender = false;
}

class FaqUserGroupsControllerTest extends CakeTestCase {
	var $FaqUserGroups = null;

	function startTest() {
		$this->FaqUserGroups = new TestFaqUserGroups();
		$this->FaqUserGroups->constructClasses();
	}

	function testFaqUserGroupsControllerInstance() {
		$this->assertTrue(is_a($this->FaqUserGroups, 'FaqUserGroupsController'));
	}

	function endTest() {
		unset($this->FaqUserGroups);
	}
}
?>
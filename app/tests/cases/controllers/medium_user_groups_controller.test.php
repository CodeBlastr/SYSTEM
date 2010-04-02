<?php 
/* SVN FILE: $Id$ */
/* MediumUserGroupsController Test cases generated on: 2009-12-13 23:38:31 : 1260765511*/
App::import('Controller', 'MediumUserGroups');

class TestMediumUserGroups extends MediumUserGroupsController {
	var $autoRender = false;
}

class MediumUserGroupsControllerTest extends CakeTestCase {
	var $MediumUserGroups = null;

	function startTest() {
		$this->MediumUserGroups = new TestMediumUserGroups();
		$this->MediumUserGroups->constructClasses();
	}

	function testMediumUserGroupsControllerInstance() {
		$this->assertTrue(is_a($this->MediumUserGroups, 'MediumUserGroupsController'));
	}

	function endTest() {
		unset($this->MediumUserGroups);
	}
}
?>
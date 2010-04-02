<?php 
/* SVN FILE: $Id$ */
/* WikiUserGroupsController Test cases generated on: 2009-12-13 23:42:59 : 1260765779*/
App::import('Controller', 'WikiUserGroups');

class TestWikiUserGroups extends WikiUserGroupsController {
	var $autoRender = false;
}

class WikiUserGroupsControllerTest extends CakeTestCase {
	var $WikiUserGroups = null;

	function startTest() {
		$this->WikiUserGroups = new TestWikiUserGroups();
		$this->WikiUserGroups->constructClasses();
	}

	function testWikiUserGroupsControllerInstance() {
		$this->assertTrue(is_a($this->WikiUserGroups, 'WikiUserGroupsController'));
	}

	function endTest() {
		unset($this->WikiUserGroups);
	}
}
?>
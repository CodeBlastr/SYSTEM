<?php 
/* SVN FILE: $Id$ */
/* BlogUserGroupsController Test cases generated on: 2009-12-13 23:17:59 : 1260764279*/
App::import('Controller', 'BlogUserGroups');

class TestBlogUserGroups extends BlogUserGroupsController {
	var $autoRender = false;
}

class BlogUserGroupsControllerTest extends CakeTestCase {
	var $BlogUserGroups = null;

	function startTest() {
		$this->BlogUserGroups = new TestBlogUserGroups();
		$this->BlogUserGroups->constructClasses();
	}

	function testBlogUserGroupsControllerInstance() {
		$this->assertTrue(is_a($this->BlogUserGroups, 'BlogUserGroupsController'));
	}

	function endTest() {
		unset($this->BlogUserGroups);
	}
}
?>
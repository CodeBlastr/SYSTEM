<?php 
/* SVN FILE: $Id$ */
/* BlogPostUserGroupsController Test cases generated on: 2009-12-13 23:18:05 : 1260764285*/
App::import('Controller', 'BlogPostUserGroups');

class TestBlogPostUserGroups extends BlogPostUserGroupsController {
	var $autoRender = false;
}

class BlogPostUserGroupsControllerTest extends CakeTestCase {
	var $BlogPostUserGroups = null;

	function startTest() {
		$this->BlogPostUserGroups = new TestBlogPostUserGroups();
		$this->BlogPostUserGroups->constructClasses();
	}

	function testBlogPostUserGroupsControllerInstance() {
		$this->assertTrue(is_a($this->BlogPostUserGroups, 'BlogPostUserGroupsController'));
	}

	function endTest() {
		unset($this->BlogPostUserGroups);
	}
}
?>
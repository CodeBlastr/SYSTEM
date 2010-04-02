<?php 
/* SVN FILE: $Id$ */
/* BlogCommentsController Test cases generated on: 2009-12-13 23:13:05 : 1260763985*/
App::import('Controller', 'BlogComments');

class TestBlogComments extends BlogCommentsController {
	var $autoRender = false;
}

class BlogCommentsControllerTest extends CakeTestCase {
	var $BlogComments = null;

	function startTest() {
		$this->BlogComments = new TestBlogComments();
		$this->BlogComments->constructClasses();
	}

	function testBlogCommentsControllerInstance() {
		$this->assertTrue(is_a($this->BlogComments, 'BlogCommentsController'));
	}

	function endTest() {
		unset($this->BlogComments);
	}
}
?>
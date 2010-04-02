<?php 
/* SVN FILE: $Id$ */
/* BlogController Test cases generated on: 2009-12-13 23:11:41 : 1260763901*/
App::import('Controller', 'Blog');

class TestBlog extends BlogController {
	var $autoRender = false;
}

class BlogControllerTest extends CakeTestCase {
	var $Blog = null;

	function startTest() {
		$this->Blog = new TestBlog();
		$this->Blog->constructClasses();
	}

	function testBlogControllerInstance() {
		$this->assertTrue(is_a($this->Blog, 'BlogController'));
	}

	function endTest() {
		unset($this->Blog);
	}
}
?>
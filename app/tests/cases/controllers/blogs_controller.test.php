<?php 
/* SVN FILE: $Id$ */
/* BlogsController Test cases generated on: 2009-12-14 13:00:21 : 1260813621*/
App::import('Controller', 'Blogs');

class TestBlogs extends BlogsController {
	var $autoRender = false;
}

class BlogsControllerTest extends CakeTestCase {
	var $Blogs = null;

	function startTest() {
		$this->Blogs = new TestBlogs();
		$this->Blogs->constructClasses();
	}

	function testBlogsControllerInstance() {
		$this->assertTrue(is_a($this->Blogs, 'BlogsController'));
	}

	function endTest() {
		unset($this->Blogs);
	}
}
?>
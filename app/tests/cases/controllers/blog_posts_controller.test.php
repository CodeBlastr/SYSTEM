<?php 
/* SVN FILE: $Id$ */
/* BlogPostsController Test cases generated on: 2009-12-13 23:18:32 : 1260764312*/
App::import('Controller', 'BlogPosts');

class TestBlogPosts extends BlogPostsController {
	var $autoRender = false;
}

class BlogPostsControllerTest extends CakeTestCase {
	var $BlogPosts = null;

	function startTest() {
		$this->BlogPosts = new TestBlogPosts();
		$this->BlogPosts->constructClasses();
	}

	function testBlogPostsControllerInstance() {
		$this->assertTrue(is_a($this->BlogPosts, 'BlogPostsController'));
	}

	function endTest() {
		unset($this->BlogPosts);
	}
}
?>
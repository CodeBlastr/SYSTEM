<?php 
/* SVN FILE: $Id$ */
/* BlogPostMediaController Test cases generated on: 2009-12-13 23:18:14 : 1260764294*/
App::import('Controller', 'BlogPostMedia');

class TestBlogPostMedia extends BlogPostMediaController {
	var $autoRender = false;
}

class BlogPostMediaControllerTest extends CakeTestCase {
	var $BlogPostMedia = null;

	function startTest() {
		$this->BlogPostMedia = new TestBlogPostMedia();
		$this->BlogPostMedia->constructClasses();
	}

	function testBlogPostMediaControllerInstance() {
		$this->assertTrue(is_a($this->BlogPostMedia, 'BlogPostMediaController'));
	}

	function endTest() {
		unset($this->BlogPostMedia);
	}
}
?>
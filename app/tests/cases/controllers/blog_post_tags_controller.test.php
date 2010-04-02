<?php 
/* SVN FILE: $Id$ */
/* BlogPostTagsController Test cases generated on: 2009-12-13 23:18:09 : 1260764289*/
App::import('Controller', 'BlogPostTags');

class TestBlogPostTags extends BlogPostTagsController {
	var $autoRender = false;
}

class BlogPostTagsControllerTest extends CakeTestCase {
	var $BlogPostTags = null;

	function startTest() {
		$this->BlogPostTags = new TestBlogPostTags();
		$this->BlogPostTags->constructClasses();
	}

	function testBlogPostTagsControllerInstance() {
		$this->assertTrue(is_a($this->BlogPostTags, 'BlogPostTagsController'));
	}

	function endTest() {
		unset($this->BlogPostTags);
	}
}
?>
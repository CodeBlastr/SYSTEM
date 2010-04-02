<?php 
/* SVN FILE: $Id$ */
/* BlogPostCategoryRelationshipsController Test cases generated on: 2009-12-13 23:18:19 : 1260764299*/
App::import('Controller', 'BlogPostCategoryRelationships');

class TestBlogPostCategoryRelationships extends BlogPostCategoryRelationshipsController {
	var $autoRender = false;
}

class BlogPostCategoryRelationshipsControllerTest extends CakeTestCase {
	var $BlogPostCategoryRelationships = null;

	function startTest() {
		$this->BlogPostCategoryRelationships = new TestBlogPostCategoryRelationships();
		$this->BlogPostCategoryRelationships->constructClasses();
	}

	function testBlogPostCategoryRelationshipsControllerInstance() {
		$this->assertTrue(is_a($this->BlogPostCategoryRelationships, 'BlogPostCategoryRelationshipsController'));
	}

	function endTest() {
		unset($this->BlogPostCategoryRelationships);
	}
}
?>
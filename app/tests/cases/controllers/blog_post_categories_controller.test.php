<?php 
/* SVN FILE: $Id$ */
/* BlogPostCategoriesController Test cases generated on: 2009-12-13 23:18:27 : 1260764307*/
App::import('Controller', 'BlogPostCategories');

class TestBlogPostCategories extends BlogPostCategoriesController {
	var $autoRender = false;
}

class BlogPostCategoriesControllerTest extends CakeTestCase {
	var $BlogPostCategories = null;

	function startTest() {
		$this->BlogPostCategories = new TestBlogPostCategories();
		$this->BlogPostCategories->constructClasses();
	}

	function testBlogPostCategoriesControllerInstance() {
		$this->assertTrue(is_a($this->BlogPostCategories, 'BlogPostCategoriesController'));
	}

	function endTest() {
		unset($this->BlogPostCategories);
	}
}
?>
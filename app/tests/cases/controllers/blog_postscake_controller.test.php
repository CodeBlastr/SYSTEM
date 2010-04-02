<?php 
/* SVN FILE: $Id$ */
/* BlogPostscakeController Test cases generated on: 2009-12-13 23:14:18 : 1260764058*/
App::import('Controller', 'BlogPostscake');

class TestBlogPostscake extends BlogPostscakeController {
	var $autoRender = false;
}

class BlogPostscakeControllerTest extends CakeTestCase {
	var $BlogPostscake = null;

	function startTest() {
		$this->BlogPostscake = new TestBlogPostscake();
		$this->BlogPostscake->constructClasses();
	}

	function testBlogPostscakeControllerInstance() {
		$this->assertTrue(is_a($this->BlogPostscake, 'BlogPostscakeController'));
	}

	function endTest() {
		unset($this->BlogPostscake);
	}
}
?>
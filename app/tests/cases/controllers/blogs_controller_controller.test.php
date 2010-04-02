<?php 
/* SVN FILE: $Id$ */
/* BlogsControllerController Test cases generated on: 2009-12-13 22:48:23 : 1260762503*/
App::import('Controller', 'BlogsController');

class TestBlogsController extends BlogsControllerController {
	var $autoRender = false;
}

class BlogsControllerControllerTest extends CakeTestCase {
	var $BlogsController = null;

	function startTest() {
		$this->BlogsController = new TestBlogsController();
		$this->BlogsController->constructClasses();
	}

	function testBlogsControllerControllerInstance() {
		$this->assertTrue(is_a($this->BlogsController, 'BlogsControllerController'));
	}

	function endTest() {
		unset($this->BlogsController);
	}
}
?>
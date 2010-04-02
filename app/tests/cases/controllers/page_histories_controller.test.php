<?php 
/* SVN FILE: $Id$ */
/* PageHistoriesController Test cases generated on: 2009-12-13 23:49:04 : 1260766144*/
App::import('Controller', 'PageHistories');

class TestPageHistories extends PageHistoriesController {
	var $autoRender = false;
}

class PageHistoriesControllerTest extends CakeTestCase {
	var $PageHistories = null;

	function startTest() {
		$this->PageHistories = new TestPageHistories();
		$this->PageHistories->constructClasses();
	}

	function testPageHistoriesControllerInstance() {
		$this->assertTrue(is_a($this->PageHistories, 'PageHistoriesController'));
	}

	function endTest() {
		unset($this->PageHistories);
	}
}
?>
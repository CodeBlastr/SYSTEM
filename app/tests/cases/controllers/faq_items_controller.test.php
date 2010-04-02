<?php 
/* SVN FILE: $Id$ */
/* FaqItemsController Test cases generated on: 2009-12-13 23:37:05 : 1260765425*/
App::import('Controller', 'FaqItems');

class TestFaqItems extends FaqItemsController {
	var $autoRender = false;
}

class FaqItemsControllerTest extends CakeTestCase {
	var $FaqItems = null;

	function startTest() {
		$this->FaqItems = new TestFaqItems();
		$this->FaqItems->constructClasses();
	}

	function testFaqItemsControllerInstance() {
		$this->assertTrue(is_a($this->FaqItems, 'FaqItemsController'));
	}

	function endTest() {
		unset($this->FaqItems);
	}
}
?>
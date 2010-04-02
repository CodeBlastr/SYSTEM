<?php 
/* SVN FILE: $Id$ */
/* QuoteItemsController Test cases generated on: 2009-12-13 23:40:47 : 1260765647*/
App::import('Controller', 'QuoteItems');

class TestQuoteItems extends QuoteItemsController {
	var $autoRender = false;
}

class QuoteItemsControllerTest extends CakeTestCase {
	var $QuoteItems = null;

	function startTest() {
		$this->QuoteItems = new TestQuoteItems();
		$this->QuoteItems->constructClasses();
	}

	function testQuoteItemsControllerInstance() {
		$this->assertTrue(is_a($this->QuoteItems, 'QuoteItemsController'));
	}

	function endTest() {
		unset($this->QuoteItems);
	}
}
?>
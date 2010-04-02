<?php 
/* SVN FILE: $Id$ */
/* QuotesController Test cases generated on: 2009-12-13 23:40:42 : 1260765642*/
App::import('Controller', 'Quotes');

class TestQuotes extends QuotesController {
	var $autoRender = false;
}

class QuotesControllerTest extends CakeTestCase {
	var $Quotes = null;

	function startTest() {
		$this->Quotes = new TestQuotes();
		$this->Quotes->constructClasses();
	}

	function testQuotesControllerInstance() {
		$this->assertTrue(is_a($this->Quotes, 'QuotesController'));
	}

	function endTest() {
		unset($this->Quotes);
	}
}
?>
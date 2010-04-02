<?php 
/* SVN FILE: $Id$ */
/* QuoteItemRelationshipsController Test cases generated on: 2009-12-13 23:40:52 : 1260765652*/
App::import('Controller', 'QuoteItemRelationships');

class TestQuoteItemRelationships extends QuoteItemRelationshipsController {
	var $autoRender = false;
}

class QuoteItemRelationshipsControllerTest extends CakeTestCase {
	var $QuoteItemRelationships = null;

	function startTest() {
		$this->QuoteItemRelationships = new TestQuoteItemRelationships();
		$this->QuoteItemRelationships->constructClasses();
	}

	function testQuoteItemRelationshipsControllerInstance() {
		$this->assertTrue(is_a($this->QuoteItemRelationships, 'QuoteItemRelationshipsController'));
	}

	function endTest() {
		unset($this->QuoteItemRelationships);
	}
}
?>
<?php 
/* SVN FILE: $Id$ */
/* QuoteTagsController Test cases generated on: 2009-12-13 23:41:05 : 1260765665*/
App::import('Controller', 'QuoteTags');

class TestQuoteTags extends QuoteTagsController {
	var $autoRender = false;
}

class QuoteTagsControllerTest extends CakeTestCase {
	var $QuoteTags = null;

	function startTest() {
		$this->QuoteTags = new TestQuoteTags();
		$this->QuoteTags->constructClasses();
	}

	function testQuoteTagsControllerInstance() {
		$this->assertTrue(is_a($this->QuoteTags, 'QuoteTagsController'));
	}

	function endTest() {
		unset($this->QuoteTags);
	}
}
?>
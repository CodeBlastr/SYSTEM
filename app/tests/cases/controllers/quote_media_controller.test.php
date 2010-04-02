<?php 
/* SVN FILE: $Id$ */
/* QuoteMediaController Test cases generated on: 2009-12-13 23:41:01 : 1260765661*/
App::import('Controller', 'QuoteMedia');

class TestQuoteMedia extends QuoteMediaController {
	var $autoRender = false;
}

class QuoteMediaControllerTest extends CakeTestCase {
	var $QuoteMedia = null;

	function startTest() {
		$this->QuoteMedia = new TestQuoteMedia();
		$this->QuoteMedia->constructClasses();
	}

	function testQuoteMediaControllerInstance() {
		$this->assertTrue(is_a($this->QuoteMedia, 'QuoteMediaController'));
	}

	function endTest() {
		unset($this->QuoteMedia);
	}
}
?>
<?php 
/* SVN FILE: $Id$ */
/* TagMediaController Test cases generated on: 2009-12-13 23:41:19 : 1260765679*/
App::import('Controller', 'TagMedia');

class TestTagMedia extends TagMediaController {
	var $autoRender = false;
}

class TagMediaControllerTest extends CakeTestCase {
	var $TagMedia = null;

	function startTest() {
		$this->TagMedia = new TestTagMedia();
		$this->TagMedia->constructClasses();
	}

	function testTagMediaControllerInstance() {
		$this->assertTrue(is_a($this->TagMedia, 'TagMediaController'));
	}

	function endTest() {
		unset($this->TagMedia);
	}
}
?>
<?php 
/* SVN FILE: $Id$ */
/* PageMediaController Test cases generated on: 2009-12-13 23:49:13 : 1260766153*/
App::import('Controller', 'PageMedia');

class TestPageMedia extends PageMediaController {
	var $autoRender = false;
}

class PageMediaControllerTest extends CakeTestCase {
	var $PageMedia = null;

	function startTest() {
		$this->PageMedia = new TestPageMedia();
		$this->PageMedia->constructClasses();
	}

	function testPageMediaControllerInstance() {
		$this->assertTrue(is_a($this->PageMedia, 'PageMediaController'));
	}

	function endTest() {
		unset($this->PageMedia);
	}
}
?>
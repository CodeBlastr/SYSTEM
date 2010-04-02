<?php 
/* SVN FILE: $Id$ */
/* FaqMediaController Test cases generated on: 2009-12-13 23:37:12 : 1260765432*/
App::import('Controller', 'FaqMedia');

class TestFaqMedia extends FaqMediaController {
	var $autoRender = false;
}

class FaqMediaControllerTest extends CakeTestCase {
	var $FaqMedia = null;

	function startTest() {
		$this->FaqMedia = new TestFaqMedia();
		$this->FaqMedia->constructClasses();
	}

	function testFaqMediaControllerInstance() {
		$this->assertTrue(is_a($this->FaqMedia, 'FaqMediaController'));
	}

	function endTest() {
		unset($this->FaqMedia);
	}
}
?>
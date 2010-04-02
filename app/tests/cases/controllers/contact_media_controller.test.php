<?php 
/* SVN FILE: $Id$ */
/* ContactMediaController Test cases generated on: 2009-12-13 23:34:55 : 1260765295*/
App::import('Controller', 'ContactMedia');

class TestContactMedia extends ContactMediaController {
	var $autoRender = false;
}

class ContactMediaControllerTest extends CakeTestCase {
	var $ContactMedia = null;

	function startTest() {
		$this->ContactMedia = new TestContactMedia();
		$this->ContactMedia->constructClasses();
	}

	function testContactMediaControllerInstance() {
		$this->assertTrue(is_a($this->ContactMedia, 'ContactMediaController'));
	}

	function endTest() {
		unset($this->ContactMedia);
	}
}
?>
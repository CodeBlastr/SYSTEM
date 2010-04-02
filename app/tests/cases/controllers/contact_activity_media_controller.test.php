<?php 
/* SVN FILE: $Id$ */
/* ContactActivityMediaController Test cases generated on: 2009-12-13 23:33:46 : 1260765226*/
App::import('Controller', 'ContactActivityMedia');

class TestContactActivityMedia extends ContactActivityMediaController {
	var $autoRender = false;
}

class ContactActivityMediaControllerTest extends CakeTestCase {
	var $ContactActivityMedia = null;

	function startTest() {
		$this->ContactActivityMedia = new TestContactActivityMedia();
		$this->ContactActivityMedia->constructClasses();
	}

	function testContactActivityMediaControllerInstance() {
		$this->assertTrue(is_a($this->ContactActivityMedia, 'ContactActivityMediaController'));
	}

	function endTest() {
		unset($this->ContactActivityMedia);
	}
}
?>
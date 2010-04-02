<?php 
/* SVN FILE: $Id$ */
/* ContactTaskMediaController Test cases generated on: 2009-12-13 23:35:35 : 1260765335*/
App::import('Controller', 'ContactTaskMedia');

class TestContactTaskMedia extends ContactTaskMediaController {
	var $autoRender = false;
}

class ContactTaskMediaControllerTest extends CakeTestCase {
	var $ContactTaskMedia = null;

	function startTest() {
		$this->ContactTaskMedia = new TestContactTaskMedia();
		$this->ContactTaskMedia->constructClasses();
	}

	function testContactTaskMediaControllerInstance() {
		$this->assertTrue(is_a($this->ContactTaskMedia, 'ContactTaskMediaController'));
	}

	function endTest() {
		unset($this->ContactTaskMedia);
	}
}
?>
<?php 
/* SVN FILE: $Id$ */
/* MediaController Test cases generated on: 2009-12-13 23:38:17 : 1260765497*/
App::import('Controller', 'Media');

class TestMedia extends MediaController {
	var $autoRender = false;
}

class MediaControllerTest extends CakeTestCase {
	var $Media = null;

	function startTest() {
		$this->Media = new TestMedia();
		$this->Media->constructClasses();
	}

	function testMediaControllerInstance() {
		$this->assertTrue(is_a($this->Media, 'MediaController'));
	}

	function endTest() {
		unset($this->Media);
	}
}
?>
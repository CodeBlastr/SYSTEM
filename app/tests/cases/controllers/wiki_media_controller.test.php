<?php 
/* SVN FILE: $Id$ */
/* WikiMediaController Test cases generated on: 2009-12-13 23:42:46 : 1260765766*/
App::import('Controller', 'WikiMedia');

class TestWikiMedia extends WikiMediaController {
	var $autoRender = false;
}

class WikiMediaControllerTest extends CakeTestCase {
	var $WikiMedia = null;

	function startTest() {
		$this->WikiMedia = new TestWikiMedia();
		$this->WikiMedia->constructClasses();
	}

	function testWikiMediaControllerInstance() {
		$this->assertTrue(is_a($this->WikiMedia, 'WikiMediaController'));
	}

	function endTest() {
		unset($this->WikiMedia);
	}
}
?>
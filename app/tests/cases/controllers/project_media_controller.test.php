<?php 
/* SVN FILE: $Id$ */
/* ProjectMediaController Test cases generated on: 2009-12-13 23:39:49 : 1260765589*/
App::import('Controller', 'ProjectMedia');

class TestProjectMedia extends ProjectMediaController {
	var $autoRender = false;
}

class ProjectMediaControllerTest extends CakeTestCase {
	var $ProjectMedia = null;

	function startTest() {
		$this->ProjectMedia = new TestProjectMedia();
		$this->ProjectMedia->constructClasses();
	}

	function testProjectMediaControllerInstance() {
		$this->assertTrue(is_a($this->ProjectMedia, 'ProjectMediaController'));
	}

	function endTest() {
		unset($this->ProjectMedia);
	}
}
?>
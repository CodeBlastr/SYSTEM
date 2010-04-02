<?php 
/* SVN FILE: $Id$ */
/* WikiContentsController Test cases generated on: 2010-02-14 19:34:37 : 1266194077*/
App::import('Controller', 'WikiContents');

class TestWikiContents extends WikiContentsController {
	var $autoRender = false;
}

class WikiContentsControllerTest extends CakeTestCase {
	var $WikiContents = null;

	function startTest() {
		$this->WikiContents = new TestWikiContents();
		$this->WikiContents->constructClasses();
	}

	function testWikiContentsControllerInstance() {
		$this->assertTrue(is_a($this->WikiContents, 'WikiContentsController'));
	}

	function endTest() {
		unset($this->WikiContents);
	}
}
?>
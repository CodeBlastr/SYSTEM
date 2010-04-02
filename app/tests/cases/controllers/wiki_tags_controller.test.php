<?php 
/* SVN FILE: $Id$ */
/* WikiTagsController Test cases generated on: 2009-12-13 23:42:55 : 1260765775*/
App::import('Controller', 'WikiTags');

class TestWikiTags extends WikiTagsController {
	var $autoRender = false;
}

class WikiTagsControllerTest extends CakeTestCase {
	var $WikiTags = null;

	function startTest() {
		$this->WikiTags = new TestWikiTags();
		$this->WikiTags->constructClasses();
	}

	function testWikiTagsControllerInstance() {
		$this->assertTrue(is_a($this->WikiTags, 'WikiTagsController'));
	}

	function endTest() {
		unset($this->WikiTags);
	}
}
?>
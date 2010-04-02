<?php 
/* SVN FILE: $Id$ */
/* WikiPagesController Test cases generated on: 2010-02-14 18:25:36 : 1266189936*/
App::import('Controller', 'WikiPages');

class TestWikiPages extends WikiPagesController {
	var $autoRender = false;
}

class WikiPagesControllerTest extends CakeTestCase {
	var $WikiPages = null;

	function startTest() {
		$this->WikiPages = new TestWikiPages();
		$this->WikiPages->constructClasses();
	}

	function testWikiPagesControllerInstance() {
		$this->assertTrue(is_a($this->WikiPages, 'WikiPagesController'));
	}

	function endTest() {
		unset($this->WikiPages);
	}
}
?>
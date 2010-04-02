<?php 
/* SVN FILE: $Id$ */
/* WikiContentVersionsController Test cases generated on: 2009-12-13 23:42:41 : 1260765761*/
App::import('Controller', 'WikiContentVersions');

class TestWikiContentVersions extends WikiContentVersionsController {
	var $autoRender = false;
}

class WikiContentVersionsControllerTest extends CakeTestCase {
	var $WikiContentVersions = null;

	function startTest() {
		$this->WikiContentVersions = new TestWikiContentVersions();
		$this->WikiContentVersions->constructClasses();
	}

	function testWikiContentVersionsControllerInstance() {
		$this->assertTrue(is_a($this->WikiContentVersions, 'WikiContentVersionsController'));
	}

	function endTest() {
		unset($this->WikiContentVersions);
	}
}
?>
<?php 
/* SVN FILE: $Id$ */
/* PageTagsController Test cases generated on: 2009-12-13 23:49:17 : 1260766157*/
App::import('Controller', 'PageTags');

class TestPageTags extends PageTagsController {
	var $autoRender = false;
}

class PageTagsControllerTest extends CakeTestCase {
	var $PageTags = null;

	function startTest() {
		$this->PageTags = new TestPageTags();
		$this->PageTags->constructClasses();
	}

	function testPageTagsControllerInstance() {
		$this->assertTrue(is_a($this->PageTags, 'PageTagsController'));
	}

	function endTest() {
		unset($this->PageTags);
	}
}
?>
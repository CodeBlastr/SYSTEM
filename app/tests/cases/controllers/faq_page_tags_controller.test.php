<?php 
/* SVN FILE: $Id$ */
/* FaqPageTagsController Test cases generated on: 2009-12-13 23:37:34 : 1260765454*/
App::import('Controller', 'FaqPageTags');

class TestFaqPageTags extends FaqPageTagsController {
	var $autoRender = false;
}

class FaqPageTagsControllerTest extends CakeTestCase {
	var $FaqPageTags = null;

	function startTest() {
		$this->FaqPageTags = new TestFaqPageTags();
		$this->FaqPageTags->constructClasses();
	}

	function testFaqPageTagsControllerInstance() {
		$this->assertTrue(is_a($this->FaqPageTags, 'FaqPageTagsController'));
	}

	function endTest() {
		unset($this->FaqPageTags);
	}
}
?>
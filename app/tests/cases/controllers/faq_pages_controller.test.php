<?php 
/* SVN FILE: $Id$ */
/* FaqPagesController Test cases generated on: 2009-12-13 23:37:22 : 1260765442*/
App::import('Controller', 'FaqPages');

class TestFaqPages extends FaqPagesController {
	var $autoRender = false;
}

class FaqPagesControllerTest extends CakeTestCase {
	var $FaqPages = null;

	function startTest() {
		$this->FaqPages = new TestFaqPages();
		$this->FaqPages->constructClasses();
	}

	function testFaqPagesControllerInstance() {
		$this->assertTrue(is_a($this->FaqPages, 'FaqPagesController'));
	}

	function endTest() {
		unset($this->FaqPages);
	}
}
?>
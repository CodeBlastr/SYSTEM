<?php 
/* SVN FILE: $Id$ */
/* MediumTagsController Test cases generated on: 2009-12-13 23:38:22 : 1260765502*/
App::import('Controller', 'MediumTags');

class TestMediumTags extends MediumTagsController {
	var $autoRender = false;
}

class MediumTagsControllerTest extends CakeTestCase {
	var $MediumTags = null;

	function startTest() {
		$this->MediumTags = new TestMediumTags();
		$this->MediumTags->constructClasses();
	}

	function testMediumTagsControllerInstance() {
		$this->assertTrue(is_a($this->MediumTags, 'MediumTagsController'));
	}

	function endTest() {
		unset($this->MediumTags);
	}
}
?>
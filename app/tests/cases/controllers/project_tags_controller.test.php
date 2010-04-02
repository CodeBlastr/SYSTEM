<?php 
/* SVN FILE: $Id$ */
/* ProjectTagsController Test cases generated on: 2009-12-13 23:40:11 : 1260765611*/
App::import('Controller', 'ProjectTags');

class TestProjectTags extends ProjectTagsController {
	var $autoRender = false;
}

class ProjectTagsControllerTest extends CakeTestCase {
	var $ProjectTags = null;

	function startTest() {
		$this->ProjectTags = new TestProjectTags();
		$this->ProjectTags->constructClasses();
	}

	function testProjectTagsControllerInstance() {
		$this->assertTrue(is_a($this->ProjectTags, 'ProjectTagsController'));
	}

	function endTest() {
		unset($this->ProjectTags);
	}
}
?>
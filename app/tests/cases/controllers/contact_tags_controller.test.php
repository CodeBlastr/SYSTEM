<?php 
/* SVN FILE: $Id$ */
/* ContactTagsController Test cases generated on: 2009-12-13 23:35:25 : 1260765325*/
App::import('Controller', 'ContactTags');

class TestContactTags extends ContactTagsController {
	var $autoRender = false;
}

class ContactTagsControllerTest extends CakeTestCase {
	var $ContactTags = null;

	function startTest() {
		$this->ContactTags = new TestContactTags();
		$this->ContactTags->constructClasses();
	}

	function testContactTagsControllerInstance() {
		$this->assertTrue(is_a($this->ContactTags, 'ContactTagsController'));
	}

	function endTest() {
		unset($this->ContactTags);
	}
}
?>
<?php 
/* SVN FILE: $Id$ */
/* TicketTagsController Test cases generated on: 2009-12-13 23:41:42 : 1260765702*/
App::import('Controller', 'TicketTags');

class TestTicketTags extends TicketTagsController {
	var $autoRender = false;
}

class TicketTagsControllerTest extends CakeTestCase {
	var $TicketTags = null;

	function startTest() {
		$this->TicketTags = new TestTicketTags();
		$this->TicketTags->constructClasses();
	}

	function testTicketTagsControllerInstance() {
		$this->assertTrue(is_a($this->TicketTags, 'TicketTagsController'));
	}

	function endTest() {
		unset($this->TicketTags);
	}
}
?>
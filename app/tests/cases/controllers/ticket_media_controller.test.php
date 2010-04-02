<?php 
/* SVN FILE: $Id$ */
/* TicketMediaController Test cases generated on: 2009-12-13 23:41:37 : 1260765697*/
App::import('Controller', 'TicketMedia');

class TestTicketMedia extends TicketMediaController {
	var $autoRender = false;
}

class TicketMediaControllerTest extends CakeTestCase {
	var $TicketMedia = null;

	function startTest() {
		$this->TicketMedia = new TestTicketMedia();
		$this->TicketMedia->constructClasses();
	}

	function testTicketMediaControllerInstance() {
		$this->assertTrue(is_a($this->TicketMedia, 'TicketMediaController'));
	}

	function endTest() {
		unset($this->TicketMedia);
	}
}
?>
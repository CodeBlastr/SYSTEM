<?php 
/* SVN FILE: $Id$ */
/* TicketTypesController Test cases generated on: 2009-12-13 23:41:51 : 1260765711*/
App::import('Controller', 'TicketTypes');

class TestTicketTypes extends TicketTypesController {
	var $autoRender = false;
}

class TicketTypesControllerTest extends CakeTestCase {
	var $TicketTypes = null;

	function startTest() {
		$this->TicketTypes = new TestTicketTypes();
		$this->TicketTypes->constructClasses();
	}

	function testTicketTypesControllerInstance() {
		$this->assertTrue(is_a($this->TicketTypes, 'TicketTypesController'));
	}

	function endTest() {
		unset($this->TicketTypes);
	}
}
?>
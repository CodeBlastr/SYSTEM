<?php 
/* SVN FILE: $Id$ */
/* TicketUserGroupsController Test cases generated on: 2009-12-13 23:41:56 : 1260765716*/
App::import('Controller', 'TicketUserGroups');

class TestTicketUserGroups extends TicketUserGroupsController {
	var $autoRender = false;
}

class TicketUserGroupsControllerTest extends CakeTestCase {
	var $TicketUserGroups = null;

	function startTest() {
		$this->TicketUserGroups = new TestTicketUserGroups();
		$this->TicketUserGroups->constructClasses();
	}

	function testTicketUserGroupsControllerInstance() {
		$this->assertTrue(is_a($this->TicketUserGroups, 'TicketUserGroupsController'));
	}

	function endTest() {
		unset($this->TicketUserGroups);
	}
}
?>
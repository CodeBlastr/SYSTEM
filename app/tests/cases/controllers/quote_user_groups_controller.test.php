<?php 
/* SVN FILE: $Id$ */
/* QuoteUserGroupsController Test cases generated on: 2009-12-13 23:41:10 : 1260765670*/
App::import('Controller', 'QuoteUserGroups');

class TestQuoteUserGroups extends QuoteUserGroupsController {
	var $autoRender = false;
}

class QuoteUserGroupsControllerTest extends CakeTestCase {
	var $QuoteUserGroups = null;

	function startTest() {
		$this->QuoteUserGroups = new TestQuoteUserGroups();
		$this->QuoteUserGroups->constructClasses();
	}

	function testQuoteUserGroupsControllerInstance() {
		$this->assertTrue(is_a($this->QuoteUserGroups, 'QuoteUserGroupsController'));
	}

	function endTest() {
		unset($this->QuoteUserGroups);
	}
}
?>
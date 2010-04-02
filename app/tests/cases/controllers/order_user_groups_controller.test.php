<?php 
/* SVN FILE: $Id$ */
/* OrderUserGroupsController Test cases generated on: 2009-12-13 23:39:36 : 1260765576*/
App::import('Controller', 'OrderUserGroups');

class TestOrderUserGroups extends OrderUserGroupsController {
	var $autoRender = false;
}

class OrderUserGroupsControllerTest extends CakeTestCase {
	var $OrderUserGroups = null;

	function startTest() {
		$this->OrderUserGroups = new TestOrderUserGroups();
		$this->OrderUserGroups->constructClasses();
	}

	function testOrderUserGroupsControllerInstance() {
		$this->assertTrue(is_a($this->OrderUserGroups, 'OrderUserGroupsController'));
	}

	function endTest() {
		unset($this->OrderUserGroups);
	}
}
?>
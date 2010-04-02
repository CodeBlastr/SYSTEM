<?php 
/* SVN FILE: $Id$ */
/* ContactAddressUserGroupsController Test cases generated on: 2009-12-13 23:34:27 : 1260765267*/
App::import('Controller', 'ContactAddressUserGroups');

class TestContactAddressUserGroups extends ContactAddressUserGroupsController {
	var $autoRender = false;
}

class ContactAddressUserGroupsControllerTest extends CakeTestCase {
	var $ContactAddressUserGroups = null;

	function startTest() {
		$this->ContactAddressUserGroups = new TestContactAddressUserGroups();
		$this->ContactAddressUserGroups->constructClasses();
	}

	function testContactAddressUserGroupsControllerInstance() {
		$this->assertTrue(is_a($this->ContactAddressUserGroups, 'ContactAddressUserGroupsController'));
	}

	function endTest() {
		unset($this->ContactAddressUserGroups);
	}
}
?>
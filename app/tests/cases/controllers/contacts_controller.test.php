<?php 
/* SVN FILE: $Id$ */
/* ContactsController Test cases generated on: 2009-12-14 21:05:27 : 1260842727*/
App::import('Controller', 'Contacts');

class TestContacts extends ContactsController {
	var $autoRender = false;
}

class ContactsControllerTest extends CakeTestCase {
	var $Contacts = null;

	function startTest() {
		$this->Contacts = new TestContacts();
		$this->Contacts->constructClasses();
	}

	function testContactsControllerInstance() {
		$this->assertTrue(is_a($this->Contacts, 'ContactsController'));
	}

	function endTest() {
		unset($this->Contacts);
	}
}
?>
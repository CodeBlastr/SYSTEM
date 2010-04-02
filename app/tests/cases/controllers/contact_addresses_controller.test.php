<?php 
/* SVN FILE: $Id$ */
/* ContactAddressesController Test cases generated on: 2009-12-13 23:34:06 : 1260765246*/
App::import('Controller', 'ContactAddresses');

class TestContactAddresses extends ContactAddressesController {
	var $autoRender = false;
}

class ContactAddressesControllerTest extends CakeTestCase {
	var $ContactAddresses = null;

	function startTest() {
		$this->ContactAddresses = new TestContactAddresses();
		$this->ContactAddresses->constructClasses();
	}

	function testContactAddressesControllerInstance() {
		$this->assertTrue(is_a($this->ContactAddresses, 'ContactAddressesController'));
	}

	function endTest() {
		unset($this->ContactAddresses);
	}
}
?>
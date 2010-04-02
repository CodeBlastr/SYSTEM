<?php 
/* SVN FILE: $Id$ */
/* ContactAddressTypesController Test cases generated on: 2009-12-13 23:34:22 : 1260765262*/
App::import('Controller', 'ContactAddressTypes');

class TestContactAddressTypes extends ContactAddressTypesController {
	var $autoRender = false;
}

class ContactAddressTypesControllerTest extends CakeTestCase {
	var $ContactAddressTypes = null;

	function startTest() {
		$this->ContactAddressTypes = new TestContactAddressTypes();
		$this->ContactAddressTypes->constructClasses();
	}

	function testContactAddressTypesControllerInstance() {
		$this->assertTrue(is_a($this->ContactAddressTypes, 'ContactAddressTypesController'));
	}

	function endTest() {
		unset($this->ContactAddressTypes);
	}
}
?>
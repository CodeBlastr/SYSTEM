<?php 
/* SVN FILE: $Id$ */
/* ContactDetailsController Test cases generated on: 2009-12-24 11:17:26 : 1261671446*/
App::import('Controller', 'ContactDetails');

class TestContactDetails extends ContactDetailsController {
	var $autoRender = false;
}

class ContactDetailsControllerTest extends CakeTestCase {
	var $ContactDetails = null;

	function startTest() {
		$this->ContactDetails = new TestContactDetails();
		$this->ContactDetails->constructClasses();
	}

	function testContactDetailsControllerInstance() {
		$this->assertTrue(is_a($this->ContactDetails, 'ContactDetailsController'));
	}

	function endTest() {
		unset($this->ContactDetails);
	}
}
?>
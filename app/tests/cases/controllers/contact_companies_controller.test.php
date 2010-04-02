<?php 
/* SVN FILE: $Id$ */
/* ContactCompaniesController Test cases generated on: 2009-12-13 23:34:31 : 1260765271*/
App::import('Controller', 'ContactCompanies');

class TestContactCompanies extends ContactCompaniesController {
	var $autoRender = false;
}

class ContactCompaniesControllerTest extends CakeTestCase {
	var $ContactCompanies = null;

	function startTest() {
		$this->ContactCompanies = new TestContactCompanies();
		$this->ContactCompanies->constructClasses();
	}

	function testContactCompaniesControllerInstance() {
		$this->assertTrue(is_a($this->ContactCompanies, 'ContactCompaniesController'));
	}

	function endTest() {
		unset($this->ContactCompanies);
	}
}
?>
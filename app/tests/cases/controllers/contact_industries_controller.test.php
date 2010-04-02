<?php 
/* SVN FILE: $Id$ */
/* ContactIndustriesController Test cases generated on: 2009-12-13 23:34:49 : 1260765289*/
App::import('Controller', 'ContactIndustries');

class TestContactIndustries extends ContactIndustriesController {
	var $autoRender = false;
}

class ContactIndustriesControllerTest extends CakeTestCase {
	var $ContactIndustries = null;

	function startTest() {
		$this->ContactIndustries = new TestContactIndustries();
		$this->ContactIndustries->constructClasses();
	}

	function testContactIndustriesControllerInstance() {
		$this->assertTrue(is_a($this->ContactIndustries, 'ContactIndustriesController'));
	}

	function endTest() {
		unset($this->ContactIndustries);
	}
}
?>
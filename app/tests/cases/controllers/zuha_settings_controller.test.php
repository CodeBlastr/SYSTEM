<?php 
/* SVN FILE: $Id$ */
/* ZuhaSettingsController Test cases generated on: 2009-12-14 10:14:24 : 1260803664*/
App::import('Controller', 'ZuhaSettings');

class TestZuhaSettings extends ZuhaSettingsController {
	var $autoRender = false;
}

class ZuhaSettingsControllerTest extends CakeTestCase {
	var $ZuhaSettings = null;

	function startTest() {
		$this->ZuhaSettings = new TestZuhaSettings();
		$this->ZuhaSettings->constructClasses();
	}

	function testZuhaSettingsControllerInstance() {
		$this->assertTrue(is_a($this->ZuhaSettings, 'ZuhaSettingsController'));
	}

	function endTest() {
		unset($this->ZuhaSettings);
	}
}
?>
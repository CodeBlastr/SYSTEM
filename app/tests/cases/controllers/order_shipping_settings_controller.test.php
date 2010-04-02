<?php 
/* SVN FILE: $Id$ */
/* OrderShippingSettingsController Test cases generated on: 2009-12-13 23:39:14 : 1260765554*/
App::import('Controller', 'OrderShippingSettings');

class TestOrderShippingSettings extends OrderShippingSettingsController {
	var $autoRender = false;
}

class OrderShippingSettingsControllerTest extends CakeTestCase {
	var $OrderShippingSettings = null;

	function startTest() {
		$this->OrderShippingSettings = new TestOrderShippingSettings();
		$this->OrderShippingSettings->constructClasses();
	}

	function testOrderShippingSettingsControllerInstance() {
		$this->assertTrue(is_a($this->OrderShippingSettings, 'OrderShippingSettingsController'));
	}

	function endTest() {
		unset($this->OrderShippingSettings);
	}
}
?>
<?php 
/* SVN FILE: $Id$ */
/* OrderPaymentSettingsController Test cases generated on: 2009-12-13 23:39:03 : 1260765543*/
App::import('Controller', 'OrderPaymentSettings');

class TestOrderPaymentSettings extends OrderPaymentSettingsController {
	var $autoRender = false;
}

class OrderPaymentSettingsControllerTest extends CakeTestCase {
	var $OrderPaymentSettings = null;

	function startTest() {
		$this->OrderPaymentSettings = new TestOrderPaymentSettings();
		$this->OrderPaymentSettings->constructClasses();
	}

	function testOrderPaymentSettingsControllerInstance() {
		$this->assertTrue(is_a($this->OrderPaymentSettings, 'OrderPaymentSettingsController'));
	}

	function endTest() {
		unset($this->OrderPaymentSettings);
	}
}
?>
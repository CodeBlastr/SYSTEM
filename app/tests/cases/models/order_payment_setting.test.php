<?php 
/* SVN FILE: $Id$ */
/* OrderPaymentSetting Test cases generated on: 2009-12-14 00:53:15 : 1260769995*/
App::import('Model', 'OrderPaymentSetting');

class OrderPaymentSettingTestCase extends CakeTestCase {
	var $OrderPaymentSetting = null;
	var $fixtures = array('app.order_payment_setting', 'app.order_payment_type');

	function startTest() {
		$this->OrderPaymentSetting =& ClassRegistry::init('OrderPaymentSetting');
	}

	function testOrderPaymentSettingInstance() {
		$this->assertTrue(is_a($this->OrderPaymentSetting, 'OrderPaymentSetting'));
	}

	function testOrderPaymentSettingFind() {
		$this->OrderPaymentSetting->recursive = -1;
		$results = $this->OrderPaymentSetting->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('OrderPaymentSetting' => array(
			'id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'value'  => 'Lorem ipsum dolor sit amet',
			'order_payment_type_id'  => 1,
			'created'  => '2009-12-14 00:53:15',
			'modified'  => '2009-12-14 00:53:15'
		));
		$this->assertEqual($results, $expected);
	}
}
?>
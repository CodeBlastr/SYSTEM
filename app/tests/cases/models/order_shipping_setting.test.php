<?php 
/* SVN FILE: $Id$ */
/* OrderShippingSetting Test cases generated on: 2009-12-14 00:53:39 : 1260770019*/
App::import('Model', 'OrderShippingSetting');

class OrderShippingSettingTestCase extends CakeTestCase {
	var $OrderShippingSetting = null;
	var $fixtures = array('app.order_shipping_setting', 'app.order_shipping_type');

	function startTest() {
		$this->OrderShippingSetting =& ClassRegistry::init('OrderShippingSetting');
	}

	function testOrderShippingSettingInstance() {
		$this->assertTrue(is_a($this->OrderShippingSetting, 'OrderShippingSetting'));
	}

	function testOrderShippingSettingFind() {
		$this->OrderShippingSetting->recursive = -1;
		$results = $this->OrderShippingSetting->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('OrderShippingSetting' => array(
			'id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'value'  => 'Lorem ipsum dolor sit amet',
			'order_shipping_type_id'  => 1,
			'created'  => '2009-12-14 00:53:39',
			'modified'  => '2009-12-14 00:53:39'
		));
		$this->assertEqual($results, $expected);
	}
}
?>
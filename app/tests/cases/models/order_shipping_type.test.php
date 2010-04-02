<?php 
/* SVN FILE: $Id$ */
/* OrderShippingType Test cases generated on: 2009-12-14 00:53:54 : 1260770034*/
App::import('Model', 'OrderShippingType');

class OrderShippingTypeTestCase extends CakeTestCase {
	var $OrderShippingType = null;
	var $fixtures = array('app.order_shipping_type', 'app.order_shipping_setting', 'app.order');

	function startTest() {
		$this->OrderShippingType =& ClassRegistry::init('OrderShippingType');
	}

	function testOrderShippingTypeInstance() {
		$this->assertTrue(is_a($this->OrderShippingType, 'OrderShippingType'));
	}

	function testOrderShippingTypeFind() {
		$this->OrderShippingType->recursive = -1;
		$results = $this->OrderShippingType->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('OrderShippingType' => array(
			'id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'summary'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'price'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'published'  => 1,
			'created'  => '2009-12-14 00:53:54',
			'modified'  => '2009-12-14 00:53:54'
		));
		$this->assertEqual($results, $expected);
	}
}
?>
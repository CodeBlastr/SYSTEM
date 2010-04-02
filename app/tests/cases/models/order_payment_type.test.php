<?php 
/* SVN FILE: $Id$ */
/* OrderPaymentType Test cases generated on: 2009-12-14 00:53:28 : 1260770008*/
App::import('Model', 'OrderPaymentType');

class OrderPaymentTypeTestCase extends CakeTestCase {
	var $OrderPaymentType = null;
	var $fixtures = array('app.order_payment_type', 'app.order_payment_setting', 'app.order');

	function startTest() {
		$this->OrderPaymentType =& ClassRegistry::init('OrderPaymentType');
	}

	function testOrderPaymentTypeInstance() {
		$this->assertTrue(is_a($this->OrderPaymentType, 'OrderPaymentType'));
	}

	function testOrderPaymentTypeFind() {
		$this->OrderPaymentType->recursive = -1;
		$results = $this->OrderPaymentType->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('OrderPaymentType' => array(
			'id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'summary'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'published'  => 1,
			'created'  => '2009-12-14 00:53:28',
			'modified'  => '2009-12-14 00:53:28'
		));
		$this->assertEqual($results, $expected);
	}
}
?>
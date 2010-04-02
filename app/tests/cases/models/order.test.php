<?php 
/* SVN FILE: $Id$ */
/* Order Test cases generated on: 2010-01-03 20:08:10 : 1262567290*/
App::import('Model', 'Order');

class OrderTestCase extends CakeTestCase {
	var $Order = null;
	var $fixtures = array('app.order', 'app.order_payment_type', 'app.order_shipping_type', 'app.order_status_type', 'app.assignee', 'app.contact', 'app.creator', 'app.modifier');

	function startTest() {
		$this->Order =& ClassRegistry::init('Order');
	}

	function testOrderInstance() {
		$this->assertTrue(is_a($this->Order, 'Order'));
	}

	function testOrderFind() {
		$this->Order->recursive = -1;
		$results = $this->Order->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Order' => array(
			'id'  => 1,
			'order_payment_type_id'  => 1,
			'order_shipping_type_id'  => 1,
			'order_status_type_id'  => 1,
			'introduction'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'conclusion'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'assignee_id'  => 1,
			'contact_id'  => 1,
			'creator_id'  => 1,
			'modifier_id'  => 1,
			'created'  => '2010-01-03 20:08:08',
			'modified'  => '2010-01-03 20:08:08'
		));
		$this->assertEqual($results, $expected);
	}
}
?>
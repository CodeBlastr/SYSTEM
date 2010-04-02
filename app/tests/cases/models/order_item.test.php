<?php 
/* SVN FILE: $Id$ */
/* OrderItem Test cases generated on: 2009-12-14 00:52:46 : 1260769966*/
App::import('Model', 'OrderItem');

class OrderItemTestCase extends CakeTestCase {
	var $OrderItem = null;
	var $fixtures = array('app.order_item', 'app.user', 'app.order', 'app.catalog_item');

	function startTest() {
		$this->OrderItem =& ClassRegistry::init('OrderItem');
	}

	function testOrderItemInstance() {
		$this->assertTrue(is_a($this->OrderItem, 'OrderItem'));
	}

	function testOrderItemFind() {
		$this->OrderItem->recursive = -1;
		$results = $this->OrderItem->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('OrderItem' => array(
			'id'  => 1,
			'quantity'  => 1,
			'user_id'  => 1,
			'order_id'  => 1,
			'catalog_item_id'  => 1,
			'created'  => '2009-12-14 00:52:46',
			'modified'  => '2009-12-14 00:52:46'
		));
		$this->assertEqual($results, $expected);
	}
}
?>
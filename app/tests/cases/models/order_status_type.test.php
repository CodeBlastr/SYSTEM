<?php 
/* SVN FILE: $Id$ */
/* OrderStatusType Test cases generated on: 2009-12-14 00:54:05 : 1260770045*/
App::import('Model', 'OrderStatusType');

class OrderStatusTypeTestCase extends CakeTestCase {
	var $OrderStatusType = null;
	var $fixtures = array('app.order_status_type', 'app.order');

	function startTest() {
		$this->OrderStatusType =& ClassRegistry::init('OrderStatusType');
	}

	function testOrderStatusTypeInstance() {
		$this->assertTrue(is_a($this->OrderStatusType, 'OrderStatusType'));
	}

	function testOrderStatusTypeFind() {
		$this->OrderStatusType->recursive = -1;
		$results = $this->OrderStatusType->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('OrderStatusType' => array(
			'id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'created'  => '2009-12-14 00:54:04',
			'modified'  => '2009-12-14 00:54:04'
		));
		$this->assertEqual($results, $expected);
	}
}
?>
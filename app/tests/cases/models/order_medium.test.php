<?php 
/* SVN FILE: $Id$ */
/* OrderMedium Test cases generated on: 2009-12-14 00:53:05 : 1260769985*/
App::import('Model', 'OrderMedium');

class OrderMediumTestCase extends CakeTestCase {
	var $OrderMedium = null;
	var $fixtures = array('app.order_medium', 'app.medium', 'app.order');

	function startTest() {
		$this->OrderMedium =& ClassRegistry::init('OrderMedium');
	}

	function testOrderMediumInstance() {
		$this->assertTrue(is_a($this->OrderMedium, 'OrderMedium'));
	}

	function testOrderMediumFind() {
		$this->OrderMedium->recursive = -1;
		$results = $this->OrderMedium->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('OrderMedium' => array(
			'id'  => 1,
			'medium_id'  => 1,
			'order_id'  => 1,
			'created'  => '2009-12-14 00:53:05',
			'modified'  => '2009-12-14 00:53:05'
		));
		$this->assertEqual($results, $expected);
	}
}
?>
<?php 
/* SVN FILE: $Id$ */
/* OrderTag Test cases generated on: 2009-12-14 00:54:18 : 1260770058*/
App::import('Model', 'OrderTag');

class OrderTagTestCase extends CakeTestCase {
	var $OrderTag = null;
	var $fixtures = array('app.order_tag', 'app.tag', 'app.order');

	function startTest() {
		$this->OrderTag =& ClassRegistry::init('OrderTag');
	}

	function testOrderTagInstance() {
		$this->assertTrue(is_a($this->OrderTag, 'OrderTag'));
	}

	function testOrderTagFind() {
		$this->OrderTag->recursive = -1;
		$results = $this->OrderTag->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('OrderTag' => array(
			'id'  => 1,
			'tag_id'  => 1,
			'order_id'  => 1,
			'created'  => '2009-12-14 00:54:18',
			'modified'  => '2009-12-14 00:54:18'
		));
		$this->assertEqual($results, $expected);
	}
}
?>
<?php 
/* SVN FILE: $Id$ */
/* OrderUserGroup Test cases generated on: 2009-12-14 00:54:35 : 1260770075*/
App::import('Model', 'OrderUserGroup');

class OrderUserGroupTestCase extends CakeTestCase {
	var $OrderUserGroup = null;
	var $fixtures = array('app.order_user_group', 'app.order', 'app.user_group');

	function startTest() {
		$this->OrderUserGroup =& ClassRegistry::init('OrderUserGroup');
	}

	function testOrderUserGroupInstance() {
		$this->assertTrue(is_a($this->OrderUserGroup, 'OrderUserGroup'));
	}

	function testOrderUserGroupFind() {
		$this->OrderUserGroup->recursive = -1;
		$results = $this->OrderUserGroup->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('OrderUserGroup' => array(
			'id'  => 1,
			'order_id'  => 1,
			'user_group_id'  => 1,
			'created'  => '2009-12-14 00:54:35',
			'modified'  => '2009-12-14 00:54:35'
		));
		$this->assertEqual($results, $expected);
	}
}
?>
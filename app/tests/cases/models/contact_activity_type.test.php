<?php 
/* SVN FILE: $Id$ */
/* ContactActivityType Test cases generated on: 2009-12-23 07:55:25 : 1261572925*/
App::import('Model', 'ContactActivityType');

class ContactActivityTypeTestCase extends CakeTestCase {
	var $ContactActivityType = null;
	var $fixtures = array('app.contact_activity_type', 'app.contact_activity');

	function startTest() {
		$this->ContactActivityType =& ClassRegistry::init('ContactActivityType');
	}

	function testContactActivityTypeInstance() {
		$this->assertTrue(is_a($this->ContactActivityType, 'ContactActivityType'));
	}

	function testContactActivityTypeFind() {
		$this->ContactActivityType->recursive = -1;
		$results = $this->ContactActivityType->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('ContactActivityType' => array(
			'id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'created'  => '2009-12-23 07:55:24',
			'modified'  => '2009-12-23 07:55:24'
		));
		$this->assertEqual($results, $expected);
	}
}
?>
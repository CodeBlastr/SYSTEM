<?php 
/* SVN FILE: $Id$ */
/* State Test cases generated on: 2010-01-05 22:04:25 : 1262747065*/
App::import('Model', 'State');

class StateTestCase extends CakeTestCase {
	var $State = null;
	var $fixtures = array('app.state', 'app.country', 'app.contact_address');

	function startTest() {
		$this->State =& ClassRegistry::init('State');
	}

	function testStateInstance() {
		$this->assertTrue(is_a($this->State, 'State'));
	}

	function testStateFind() {
		$this->State->recursive = -1;
		$results = $this->State->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('State' => array(
			'id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'country_id'  => 1,
			'created'  => '2010-01-05 22:04:25',
			'modified'  => '2010-01-05 22:04:25'
		));
		$this->assertEqual($results, $expected);
	}
}
?>
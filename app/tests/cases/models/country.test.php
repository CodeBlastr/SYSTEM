<?php 
/* SVN FILE: $Id$ */
/* Country Test cases generated on: 2010-01-05 22:05:08 : 1262747108*/
App::import('Model', 'Country');

class CountryTestCase extends CakeTestCase {
	var $Country = null;
	var $fixtures = array('app.country', 'app.contact_address', 'app.state');

	function startTest() {
		$this->Country =& ClassRegistry::init('Country');
	}

	function testCountryInstance() {
		$this->assertTrue(is_a($this->Country, 'Country'));
	}

	function testCountryFind() {
		$this->Country->recursive = -1;
		$results = $this->Country->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Country' => array(
			'id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'created'  => '2010-01-05 22:05:08',
			'modified'  => '2010-01-05 22:05:08'
		));
		$this->assertEqual($results, $expected);
	}
}
?>
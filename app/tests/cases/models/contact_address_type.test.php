<?php 
/* SVN FILE: $Id$ */
/* ContactAddressType Test cases generated on: 2009-12-14 00:34:28 : 1260768868*/
App::import('Model', 'ContactAddressType');

class ContactAddressTypeTestCase extends CakeTestCase {
	var $ContactAddressType = null;
	var $fixtures = array('app.contact_address_type', 'app.contact_address');

	function startTest() {
		$this->ContactAddressType =& ClassRegistry::init('ContactAddressType');
	}

	function testContactAddressTypeInstance() {
		$this->assertTrue(is_a($this->ContactAddressType, 'ContactAddressType'));
	}

	function testContactAddressTypeFind() {
		$this->ContactAddressType->recursive = -1;
		$results = $this->ContactAddressType->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('ContactAddressType' => array(
			'id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'created'  => '2009-12-14 00:34:28',
			'modified'  => '2009-12-14 00:34:28'
		));
		$this->assertEqual($results, $expected);
	}
}
?>
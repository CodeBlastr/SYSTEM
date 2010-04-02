<?php 
/* SVN FILE: $Id$ */
/* ContactAddress Test cases generated on: 2010-01-03 16:18:08 : 1262553488*/
App::import('Model', 'ContactAddress');

class ContactAddressTestCase extends CakeTestCase {
	var $ContactAddress = null;
	var $fixtures = array('app.contact_address', 'app.contact_address_type', 'app.state', 'app.country', 'app.contact', 'app.creator', 'app.modifier');

	function startTest() {
		$this->ContactAddress =& ClassRegistry::init('ContactAddress');
	}

	function testContactAddressInstance() {
		$this->assertTrue(is_a($this->ContactAddress, 'ContactAddress'));
	}

	function testContactAddressFind() {
		$this->ContactAddress->recursive = -1;
		$results = $this->ContactAddress->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('ContactAddress' => array(
			'id'  => 1,
			'contact_address_type_id'  => 1,
			'street1'  => 'Lorem ipsum dolor sit amet',
			'street2'  => 'Lorem ipsum dolor sit amet',
			'city'  => 'Lorem ipsum dolor sit amet',
			'state_id'  => 1,
			'zip_postal'  => 'Lorem ipsum dolor sit amet',
			'country_id'  => 1,
			'primary'  => 1,
			'contact_id'  => 1,
			'creator_id'  => 1,
			'modifier_id'  => 1,
			'created'  => '2010-01-03 16:18:07',
			'modified'  => '2010-01-03 16:18:07'
		));
		$this->assertEqual($results, $expected);
	}
}
?>
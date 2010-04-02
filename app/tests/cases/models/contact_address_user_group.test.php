<?php 
/* SVN FILE: $Id$ */
/* ContactAddressUserGroup Test cases generated on: 2009-12-14 00:34:50 : 1260768890*/
App::import('Model', 'ContactAddressUserGroup');

class ContactAddressUserGroupTestCase extends CakeTestCase {
	var $ContactAddressUserGroup = null;
	var $fixtures = array('app.contact_address_user_group', 'app.user_group', 'app.contact_address');

	function startTest() {
		$this->ContactAddressUserGroup =& ClassRegistry::init('ContactAddressUserGroup');
	}

	function testContactAddressUserGroupInstance() {
		$this->assertTrue(is_a($this->ContactAddressUserGroup, 'ContactAddressUserGroup'));
	}

	function testContactAddressUserGroupFind() {
		$this->ContactAddressUserGroup->recursive = -1;
		$results = $this->ContactAddressUserGroup->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('ContactAddressUserGroup' => array(
			'id'  => 1,
			'user_group_id'  => 1,
			'contact_address_id'  => 1,
			'created'  => '2009-12-14 00:34:50',
			'modified'  => '2009-12-14 00:34:50'
		));
		$this->assertEqual($results, $expected);
	}
}
?>
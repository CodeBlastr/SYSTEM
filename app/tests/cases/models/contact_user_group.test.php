<?php 
/* SVN FILE: $Id$ */
/* ContactUserGroup Test cases generated on: 2009-12-14 00:43:09 : 1260769389*/
App::import('Model', 'ContactUserGroup');

class ContactUserGroupTestCase extends CakeTestCase {
	var $ContactUserGroup = null;
	var $fixtures = array('app.contact_user_group', 'app.contact', 'app.user_group');

	function startTest() {
		$this->ContactUserGroup =& ClassRegistry::init('ContactUserGroup');
	}

	function testContactUserGroupInstance() {
		$this->assertTrue(is_a($this->ContactUserGroup, 'ContactUserGroup'));
	}

	function testContactUserGroupFind() {
		$this->ContactUserGroup->recursive = -1;
		$results = $this->ContactUserGroup->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('ContactUserGroup' => array(
			'id'  => 1,
			'contact_id'  => 1,
			'user_group_id'  => 1,
			'created'  => '2009-12-14 00:43:09',
			'modified'  => '2009-12-14 00:43:09'
		));
		$this->assertEqual($results, $expected);
	}
}
?>
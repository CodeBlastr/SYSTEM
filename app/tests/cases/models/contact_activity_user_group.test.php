<?php 
/* SVN FILE: $Id$ */
/* ContactActivityUserGroup Test cases generated on: 2009-12-14 00:34:01 : 1260768841*/
App::import('Model', 'ContactActivityUserGroup');

class ContactActivityUserGroupTestCase extends CakeTestCase {
	var $ContactActivityUserGroup = null;
	var $fixtures = array('app.contact_activity_user_group', 'app.user_group', 'app.contact_activity');

	function startTest() {
		$this->ContactActivityUserGroup =& ClassRegistry::init('ContactActivityUserGroup');
	}

	function testContactActivityUserGroupInstance() {
		$this->assertTrue(is_a($this->ContactActivityUserGroup, 'ContactActivityUserGroup'));
	}

	function testContactActivityUserGroupFind() {
		$this->ContactActivityUserGroup->recursive = -1;
		$results = $this->ContactActivityUserGroup->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('ContactActivityUserGroup' => array(
			'id'  => 1,
			'user_group_id'  => 1,
			'contact_activity_id'  => 1,
			'created'  => '2009-12-14 00:34:01',
			'modified'  => '2009-12-14 00:34:01'
		));
		$this->assertEqual($results, $expected);
	}
}
?>
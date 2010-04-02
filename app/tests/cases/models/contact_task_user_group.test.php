<?php 
/* SVN FILE: $Id$ */
/* ContactTaskUserGroup Test cases generated on: 2009-12-14 00:42:22 : 1260769342*/
App::import('Model', 'ContactTaskUserGroup');

class ContactTaskUserGroupTestCase extends CakeTestCase {
	var $ContactTaskUserGroup = null;
	var $fixtures = array('app.contact_task_user_group', 'app.user_group', 'app.contact_task');

	function startTest() {
		$this->ContactTaskUserGroup =& ClassRegistry::init('ContactTaskUserGroup');
	}

	function testContactTaskUserGroupInstance() {
		$this->assertTrue(is_a($this->ContactTaskUserGroup, 'ContactTaskUserGroup'));
	}

	function testContactTaskUserGroupFind() {
		$this->ContactTaskUserGroup->recursive = -1;
		$results = $this->ContactTaskUserGroup->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('ContactTaskUserGroup' => array(
			'id'  => 1,
			'user_group_id'  => 1,
			'contact_task_id'  => 1,
			'created'  => '2009-12-14 00:42:22',
			'modified'  => '2009-12-14 00:42:22'
		));
		$this->assertEqual($results, $expected);
	}
}
?>
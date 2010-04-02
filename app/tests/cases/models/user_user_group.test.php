<?php 
/* SVN FILE: $Id$ */
/* UserUserGroup Test cases generated on: 2009-12-14 12:23:49 : 1260811429*/
App::import('Model', 'UserUserGroup');

class UserUserGroupTestCase extends CakeTestCase {
	var $UserUserGroup = null;
	var $fixtures = array('app.user_user_group', 'app.user', 'app.user_group');

	function startTest() {
		$this->UserUserGroup =& ClassRegistry::init('UserUserGroup');
	}

	function testUserUserGroupInstance() {
		$this->assertTrue(is_a($this->UserUserGroup, 'UserUserGroup'));
	}

	function testUserUserGroupFind() {
		$this->UserUserGroup->recursive = -1;
		$results = $this->UserUserGroup->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('UserUserGroup' => array(
			'id'  => 1,
			'user_id'  => 1,
			'user_group_id'  => 1,
			'created'  => '2009-12-14 12:23:49',
			'modified'  => '2009-12-14 12:23:49'
		));
		$this->assertEqual($results, $expected);
	}
}
?>
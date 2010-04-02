<?php 
/* SVN FILE: $Id$ */
/* UserGroup Test cases generated on: 2010-01-03 13:19:46 : 1262542786*/
App::import('Model', 'UserGroup');

class UserGroupTestCase extends CakeTestCase {
	var $UserGroup = null;
	var $fixtures = array('app.user_group', 'app.parent', 'app.user');

	function startTest() {
		$this->UserGroup =& ClassRegistry::init('UserGroup');
	}

	function testUserGroupInstance() {
		$this->assertTrue(is_a($this->UserGroup, 'UserGroup'));
	}

	function testUserGroupFind() {
		$this->UserGroup->recursive = -1;
		$results = $this->UserGroup->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('UserGroup' => array(
			'id'  => 1,
			'parent_id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'created'  => '2010-01-03 13:19:45',
			'modified'  => '2010-01-03 13:19:45'
		));
		$this->assertEqual($results, $expected);
	}
}
?>
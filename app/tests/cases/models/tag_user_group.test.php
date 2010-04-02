<?php 
/* SVN FILE: $Id$ */
/* TagUserGroup Test cases generated on: 2009-12-14 00:59:18 : 1260770358*/
App::import('Model', 'TagUserGroup');

class TagUserGroupTestCase extends CakeTestCase {
	var $TagUserGroup = null;
	var $fixtures = array('app.tag_user_group', 'app.tag', 'app.user_group');

	function startTest() {
		$this->TagUserGroup =& ClassRegistry::init('TagUserGroup');
	}

	function testTagUserGroupInstance() {
		$this->assertTrue(is_a($this->TagUserGroup, 'TagUserGroup'));
	}

	function testTagUserGroupFind() {
		$this->TagUserGroup->recursive = -1;
		$results = $this->TagUserGroup->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('TagUserGroup' => array(
			'id'  => 1,
			'tag_id'  => 1,
			'user_group_id'  => 1,
			'created'  => '2009-12-14 00:59:18',
			'modified'  => '2009-12-14 00:59:18'
		));
		$this->assertEqual($results, $expected);
	}
}
?>
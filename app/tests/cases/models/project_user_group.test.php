<?php 
/* SVN FILE: $Id$ */
/* ProjectUserGroup Test cases generated on: 2009-12-14 00:57:16 : 1260770236*/
App::import('Model', 'ProjectUserGroup');

class ProjectUserGroupTestCase extends CakeTestCase {
	var $ProjectUserGroup = null;
	var $fixtures = array('app.project_user_group', 'app.project', 'app.user_group');

	function startTest() {
		$this->ProjectUserGroup =& ClassRegistry::init('ProjectUserGroup');
	}

	function testProjectUserGroupInstance() {
		$this->assertTrue(is_a($this->ProjectUserGroup, 'ProjectUserGroup'));
	}

	function testProjectUserGroupFind() {
		$this->ProjectUserGroup->recursive = -1;
		$results = $this->ProjectUserGroup->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('ProjectUserGroup' => array(
			'id'  => 1,
			'project_id'  => 1,
			'user_group_id'  => 1,
			'created'  => '2009-12-14 00:57:16',
			'modified'  => '2009-12-14 00:57:16'
		));
		$this->assertEqual($results, $expected);
	}
}
?>
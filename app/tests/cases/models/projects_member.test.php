<?php 
/* SVN FILE: $Id$ */
/* ProjectsMember Test cases generated on: 2010-01-05 23:24:35 : 1262751875*/
App::import('Model', 'ProjectsMember');

class ProjectsMemberTestCase extends CakeTestCase {
	var $ProjectsMember = null;
	var $fixtures = array('app.projects_member', 'app.user', 'app.project', 'app.creator', 'app.modifier');

	function startTest() {
		$this->ProjectsMember =& ClassRegistry::init('ProjectsMember');
	}

	function testProjectsMemberInstance() {
		$this->assertTrue(is_a($this->ProjectsMember, 'ProjectsMember'));
	}

	function testProjectsMemberFind() {
		$this->ProjectsMember->recursive = -1;
		$results = $this->ProjectsMember->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('ProjectsMember' => array(
			'id'  => 1,
			'user_id'  => 1,
			'project_id'  => 1,
			'creator_id'  => 1,
			'modifier_id'  => 1,
			'created'  => '2010-01-05 23:24:34',
			'modified'  => '2010-01-05 23:24:34'
		));
		$this->assertEqual($results, $expected);
	}
}
?>
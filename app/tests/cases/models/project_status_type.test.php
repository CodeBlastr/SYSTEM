<?php 
/* SVN FILE: $Id$ */
/* ProjectStatusType Test cases generated on: 2010-01-09 22:04:24 : 1263092664*/
App::import('Model', 'ProjectStatusType');

class ProjectStatusTypeTestCase extends CakeTestCase {
	var $ProjectStatusType = null;
	var $fixtures = array('app.project_status_type', 'app.project_issue', 'app.project', 'app.project_issue', 'app.project');

	function startTest() {
		$this->ProjectStatusType =& ClassRegistry::init('ProjectStatusType');
	}

	function testProjectStatusTypeInstance() {
		$this->assertTrue(is_a($this->ProjectStatusType, 'ProjectStatusType'));
	}

	function testProjectStatusTypeFind() {
		$this->ProjectStatusType->recursive = -1;
		$results = $this->ProjectStatusType->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('ProjectStatusType' => array(
			'id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'created'  => '2010-01-09 22:04:24',
			'modified'  => '2010-01-09 22:04:24'
		));
		$this->assertEqual($results, $expected);
	}
}
?>
<?php 
/* SVN FILE: $Id$ */
/* Project Test cases generated on: 2010-01-03 20:13:11 : 1262567591*/
App::import('Model', 'Project');

class ProjectTestCase extends CakeTestCase {
	var $Project = null;
	var $fixtures = array('app.project', 'app.parent', 'app.project_priority_type', 'app.project_status_type', 'app.contact', 'app.manager', 'app.creator', 'app.modifier', 'app.project_issue', 'app.timesheet_time');

	function startTest() {
		$this->Project =& ClassRegistry::init('Project');
	}

	function testProjectInstance() {
		$this->assertTrue(is_a($this->Project, 'Project'));
	}

	function testProjectFind() {
		$this->Project->recursive = -1;
		$results = $this->Project->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Project' => array(
			'id'  => 1,
			'parent_id'  => 1,
			'project_priority_type_id'  => 1,
			'project_status_type_id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'description'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'public'  => 1,
			'contact_id'  => 1,
			'manager_id'  => 1,
			'creator_id'  => 1,
			'modifier_id'  => 1,
			'created'  => '2010-01-03 20:13:10',
			'modified'  => '2010-01-03 20:13:10'
		));
		$this->assertEqual($results, $expected);
	}
}
?>
<?php 
/* SVN FILE: $Id$ */
/* ProjectIssue Test cases generated on: 2010-01-03 20:19:08 : 1262567948*/
App::import('Model', 'ProjectIssue');

class ProjectIssueTestCase extends CakeTestCase {
	var $ProjectIssue = null;
	var $fixtures = array('app.project_issue', 'app.parent', 'app.project_priority_type', 'app.project_status_type', 'app.contact', 'app.assignee', 'app.project', 'app.project_tracker_type', 'app.creator', 'app.modifier', 'app.timesheet_time');

	function startTest() {
		$this->ProjectIssue =& ClassRegistry::init('ProjectIssue');
	}

	function testProjectIssueInstance() {
		$this->assertTrue(is_a($this->ProjectIssue, 'ProjectIssue'));
	}

	function testProjectIssueFind() {
		$this->ProjectIssue->recursive = -1;
		$results = $this->ProjectIssue->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('ProjectIssue' => array(
			'id'  => 1,
			'parent_id'  => 1,
			'lft'  => 1,
			'rght'  => 1,
			'project_priority_type_id'  => 1,
			'project_status_type_id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'description'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'start_date'  => '2010-01-03',
			'due_date'  => '2010-01-03',
			'estimated_hours'  => '2010-01-03',
			'done_ratio'  => '2010-01-03',
			'private'  => 1,
			'contact_id'  => 1,
			'assignee_id'  => 1,
			'project_id'  => 1,
			'project_tracker_type_id'  => 1,
			'creator_id'  => 1,
			'modifier_id'  => 1,
			'created'  => '2010-01-03 20:19:07',
			'modified'  => '2010-01-03 20:19:07'
		));
		$this->assertEqual($results, $expected);
	}
}
?>
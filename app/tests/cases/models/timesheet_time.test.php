<?php 
/* SVN FILE: $Id$ */
/* TimesheetTime Test cases generated on: 2010-01-03 20:35:22 : 1262568922*/
App::import('Model', 'TimesheetTime');

class TimesheetTimeTestCase extends CakeTestCase {
	var $TimesheetTime = null;
	var $fixtures = array('app.timesheet_time', 'app.project', 'app.project_issue', 'app.creator', 'app.modifier');

	function startTest() {
		$this->TimesheetTime =& ClassRegistry::init('TimesheetTime');
	}

	function testTimesheetTimeInstance() {
		$this->assertTrue(is_a($this->TimesheetTime, 'TimesheetTime'));
	}

	function testTimesheetTimeFind() {
		$this->TimesheetTime->recursive = -1;
		$results = $this->TimesheetTime->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('TimesheetTime' => array(
			'id'  => 1,
			'hours'  => 1,
			'comments'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'started_on'  => '2010-01-03 20:35:21',
			'project_id'  => 1,
			'project_issue_id'  => 1,
			'creator_id'  => 1,
			'modifier_id'  => 1,
			'created'  => '2010-01-03 20:35:21',
			'modified'  => '2010-01-03 20:35:21'
		));
		$this->assertEqual($results, $expected);
	}
}
?>
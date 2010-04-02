<?php 
/* SVN FILE: $Id$ */
/* TimesheetTimeRelationship Test cases generated on: 2010-01-03 00:03:27 : 1262495007*/
App::import('Model', 'TimesheetTimeRelationship');

class TimesheetTimeRelationshipTestCase extends CakeTestCase {
	var $TimesheetTimeRelationship = null;
	var $fixtures = array('app.timesheet_time_relationship', 'app.timesheet', 'app.timesheet_time');

	function startTest() {
		$this->TimesheetTimeRelationship =& ClassRegistry::init('TimesheetTimeRelationship');
	}

	function testTimesheetTimeRelationshipInstance() {
		$this->assertTrue(is_a($this->TimesheetTimeRelationship, 'TimesheetTimeRelationship'));
	}

	function testTimesheetTimeRelationshipFind() {
		$this->TimesheetTimeRelationship->recursive = -1;
		$results = $this->TimesheetTimeRelationship->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('TimesheetTimeRelationship' => array(
			'id'  => 1,
			'timesheet_id'  => 1,
			'timesheet_time_id'  => 1,
			'created'  => '2010-01-03 00:03:27',
			'modified'  => '2010-01-03 00:03:27'
		));
		$this->assertEqual($results, $expected);
	}
}
?>
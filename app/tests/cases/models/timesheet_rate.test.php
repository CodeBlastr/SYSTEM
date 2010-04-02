<?php 
/* SVN FILE: $Id$ */
/* TimesheetRate Test cases generated on: 2009-12-14 01:00:41 : 1260770441*/
App::import('Model', 'TimesheetRate');

class TimesheetRateTestCase extends CakeTestCase {
	var $TimesheetRate = null;
	var $fixtures = array('app.timesheet_rate', 'app.user', 'app.timesheet_time');

	function startTest() {
		$this->TimesheetRate =& ClassRegistry::init('TimesheetRate');
	}

	function testTimesheetRateInstance() {
		$this->assertTrue(is_a($this->TimesheetRate, 'TimesheetRate'));
	}

	function testTimesheetRateFind() {
		$this->TimesheetRate->recursive = -1;
		$results = $this->TimesheetRate->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('TimesheetRate' => array(
			'id'  => 1,
			'cost'  => 1,
			'wholesale'  => 1,
			'retail'  => 1,
			'user_id'  => 1,
			'created'  => '2009-12-14 01:00:41',
			'modified'  => '2009-12-14 01:00:41'
		));
		$this->assertEqual($results, $expected);
	}
}
?>
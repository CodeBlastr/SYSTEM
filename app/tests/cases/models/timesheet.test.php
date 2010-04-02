<?php 
/* SVN FILE: $Id$ */
/* Timesheet Test cases generated on: 2010-01-10 21:01:46 : 1263175306*/
App::import('Model', 'Timesheet');

class TimesheetTestCase extends CakeTestCase {
	var $Timesheet = null;
	var $fixtures = array('app.timesheet', 'app.creator', 'app.modifier');

	function startTest() {
		$this->Timesheet =& ClassRegistry::init('Timesheet');
	}

	function testTimesheetInstance() {
		$this->assertTrue(is_a($this->Timesheet, 'Timesheet'));
	}

	function testTimesheetFind() {
		$this->Timesheet->recursive = -1;
		$results = $this->Timesheet->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Timesheet' => array(
			'id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'creator_id'  => 1,
			'modifier_id'  => 1,
			'created'  => '2010-01-10 21:01:45',
			'modified'  => '2010-01-10 21:01:45'
		));
		$this->assertEqual($results, $expected);
	}
}
?>
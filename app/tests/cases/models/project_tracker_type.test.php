<?php 
/* SVN FILE: $Id$ */
/* ProjectTrackerType Test cases generated on: 2010-02-10 20:25:04 : 1265851504*/
App::import('Model', 'ProjectTrackerType');

class ProjectTrackerTypeTestCase extends CakeTestCase {
	var $ProjectTrackerType = null;
	var $fixtures = array('app.project_tracker_type', 'app.project_issue');

	function startTest() {
		$this->ProjectTrackerType =& ClassRegistry::init('ProjectTrackerType');
	}

	function testProjectTrackerTypeInstance() {
		$this->assertTrue(is_a($this->ProjectTrackerType, 'ProjectTrackerType'));
	}

	function testProjectTrackerTypeFind() {
		$this->ProjectTrackerType->recursive = -1;
		$results = $this->ProjectTrackerType->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('ProjectTrackerType' => array(
			'id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'created'  => '2010-02-10 20:25:04',
			'modified'  => '2010-02-10 20:25:04'
		));
		$this->assertEqual($results, $expected);
	}
}
?>
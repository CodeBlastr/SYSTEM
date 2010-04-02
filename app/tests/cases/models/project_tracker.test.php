<?php 
/* SVN FILE: $Id$ */
/* ProjectTracker Test cases generated on: 2009-12-14 00:57:08 : 1260770228*/
App::import('Model', 'ProjectTracker');

class ProjectTrackerTestCase extends CakeTestCase {
	var $ProjectTracker = null;
	var $fixtures = array('app.project_tracker', 'app.project_issue');

	function startTest() {
		$this->ProjectTracker =& ClassRegistry::init('ProjectTracker');
	}

	function testProjectTrackerInstance() {
		$this->assertTrue(is_a($this->ProjectTracker, 'ProjectTracker'));
	}

	function testProjectTrackerFind() {
		$this->ProjectTracker->recursive = -1;
		$results = $this->ProjectTracker->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('ProjectTracker' => array(
			'id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'created'  => '2009-12-14 00:57:08',
			'modified'  => '2009-12-14 00:57:08'
		));
		$this->assertEqual($results, $expected);
	}
}
?>
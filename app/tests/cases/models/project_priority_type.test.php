<?php 
/* SVN FILE: $Id$ */
/* ProjectPriorityType Test cases generated on: 2010-01-09 22:04:00 : 1263092640*/
App::import('Model', 'ProjectPriorityType');

class ProjectPriorityTypeTestCase extends CakeTestCase {
	var $ProjectPriorityType = null;
	var $fixtures = array('app.project_priority_type', 'app.project_issue', 'app.project');

	function startTest() {
		$this->ProjectPriorityType =& ClassRegistry::init('ProjectPriorityType');
	}

	function testProjectPriorityTypeInstance() {
		$this->assertTrue(is_a($this->ProjectPriorityType, 'ProjectPriorityType'));
	}

	function testProjectPriorityTypeFind() {
		$this->ProjectPriorityType->recursive = -1;
		$results = $this->ProjectPriorityType->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('ProjectPriorityType' => array(
			'id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'created'  => '2010-01-09 22:03:59',
			'modified'  => '2010-01-09 22:03:59'
		));
		$this->assertEqual($results, $expected);
	}
}
?>
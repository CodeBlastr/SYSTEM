<?php 
/* SVN FILE: $Id$ */
/* ProjectMedium Test cases generated on: 2009-12-14 00:56:24 : 1260770184*/
App::import('Model', 'ProjectMedium');

class ProjectMediumTestCase extends CakeTestCase {
	var $ProjectMedium = null;
	var $fixtures = array('app.project_medium', 'app.medium', 'app.project');

	function startTest() {
		$this->ProjectMedium =& ClassRegistry::init('ProjectMedium');
	}

	function testProjectMediumInstance() {
		$this->assertTrue(is_a($this->ProjectMedium, 'ProjectMedium'));
	}

	function testProjectMediumFind() {
		$this->ProjectMedium->recursive = -1;
		$results = $this->ProjectMedium->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('ProjectMedium' => array(
			'id'  => 1,
			'medium_id'  => 1,
			'project_id'  => 1,
			'created'  => '2009-12-14 00:56:24',
			'modified'  => '2009-12-14 00:56:24'
		));
		$this->assertEqual($results, $expected);
	}
}
?>
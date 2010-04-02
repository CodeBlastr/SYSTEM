<?php 
/* SVN FILE: $Id$ */
/* ProjectsWatcher Test cases generated on: 2010-01-09 21:30:43 : 1263090643*/
App::import('Model', 'ProjectsWatcher');

class ProjectsWatcherTestCase extends CakeTestCase {
	var $ProjectsWatcher = null;
	var $fixtures = array('app.projects_watcher', 'app.contact', 'app.project', 'app.creator', 'app.modifier');

	function startTest() {
		$this->ProjectsWatcher =& ClassRegistry::init('ProjectsWatcher');
	}

	function testProjectsWatcherInstance() {
		$this->assertTrue(is_a($this->ProjectsWatcher, 'ProjectsWatcher'));
	}

	function testProjectsWatcherFind() {
		$this->ProjectsWatcher->recursive = -1;
		$results = $this->ProjectsWatcher->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('ProjectsWatcher' => array(
			'id'  => 1,
			'contact_id'  => 1,
			'project_id'  => 1,
			'creator_id'  => 1,
			'modifier_id'  => 1,
			'created'  => '2010-01-09 21:30:43',
			'modified'  => '2010-01-09 21:30:43'
		));
		$this->assertEqual($results, $expected);
	}
}
?>
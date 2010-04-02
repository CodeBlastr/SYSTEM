<?php 
/* SVN FILE: $Id$ */
/* ProjectWatcher Test cases generated on: 2009-12-14 00:57:24 : 1260770244*/
App::import('Model', 'ProjectWatcher');

class ProjectWatcherTestCase extends CakeTestCase {
	var $ProjectWatcher = null;
	var $fixtures = array('app.project_watcher', 'app.user', 'app.contact', 'app.project');

	function startTest() {
		$this->ProjectWatcher =& ClassRegistry::init('ProjectWatcher');
	}

	function testProjectWatcherInstance() {
		$this->assertTrue(is_a($this->ProjectWatcher, 'ProjectWatcher'));
	}

	function testProjectWatcherFind() {
		$this->ProjectWatcher->recursive = -1;
		$results = $this->ProjectWatcher->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('ProjectWatcher' => array(
			'id'  => 1,
			'user_id'  => 1,
			'contact_id'  => 1,
			'project_id'  => 1,
			'created'  => '2009-12-14 00:57:24',
			'modified'  => '2009-12-14 00:57:24'
		));
		$this->assertEqual($results, $expected);
	}
}
?>
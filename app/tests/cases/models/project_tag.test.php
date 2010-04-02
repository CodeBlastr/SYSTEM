<?php 
/* SVN FILE: $Id$ */
/* ProjectTag Test cases generated on: 2009-12-27 17:06:54 : 1261951614*/
App::import('Model', 'ProjectTag');

class ProjectTagTestCase extends CakeTestCase {
	var $ProjectTag = null;
	var $fixtures = array('app.project_tag', 'app.tag', 'app.project');

	function startTest() {
		$this->ProjectTag =& ClassRegistry::init('ProjectTag');
	}

	function testProjectTagInstance() {
		$this->assertTrue(is_a($this->ProjectTag, 'ProjectTag'));
	}

	function testProjectTagFind() {
		$this->ProjectTag->recursive = -1;
		$results = $this->ProjectTag->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('ProjectTag' => array(
			'id'  => 1,
			'tag_id'  => 1,
			'project_id'  => 1,
			'created'  => '2009-12-27 17:06:52',
			'modified'  => '2009-12-27 17:06:52'
		));
		$this->assertEqual($results, $expected);
	}
}
?>
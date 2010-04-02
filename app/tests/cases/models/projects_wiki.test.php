<?php 
/* SVN FILE: $Id$ */
/* ProjectsWiki Test cases generated on: 2010-02-15 08:52:54 : 1266241974*/
App::import('Model', 'ProjectsWiki');

class ProjectsWikiTestCase extends CakeTestCase {
	var $ProjectsWiki = null;
	var $fixtures = array('app.projects_wiki', 'app.project', 'app.wiki');

	function startTest() {
		$this->ProjectsWiki =& ClassRegistry::init('ProjectsWiki');
	}

	function testProjectsWikiInstance() {
		$this->assertTrue(is_a($this->ProjectsWiki, 'ProjectsWiki'));
	}

	function testProjectsWikiFind() {
		$this->ProjectsWiki->recursive = -1;
		$results = $this->ProjectsWiki->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('ProjectsWiki' => array(
			'id'  => 1,
			'project_id'  => 1,
			'wiki_id'  => 1,
			'created'  => '2010-02-15 08:52:54',
			'modified'  => '2010-02-15 08:52:54'
		));
		$this->assertEqual($results, $expected);
	}
}
?>
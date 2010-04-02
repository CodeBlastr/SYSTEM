<?php 
/* SVN FILE: $Id$ */
/* ProjectWiki Test cases generated on: 2009-12-14 00:57:33 : 1260770253*/
App::import('Model', 'ProjectWiki');

class ProjectWikiTestCase extends CakeTestCase {
	var $ProjectWiki = null;
	var $fixtures = array('app.project_wiki', 'app.user', 'app.project', 'app.wiki');

	function startTest() {
		$this->ProjectWiki =& ClassRegistry::init('ProjectWiki');
	}

	function testProjectWikiInstance() {
		$this->assertTrue(is_a($this->ProjectWiki, 'ProjectWiki'));
	}

	function testProjectWikiFind() {
		$this->ProjectWiki->recursive = -1;
		$results = $this->ProjectWiki->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('ProjectWiki' => array(
			'id'  => 1,
			'start_page'  => 'Lorem ipsum dolor sit amet',
			'public'  => 1,
			'user_id'  => 1,
			'project_id'  => 1,
			'wiki_id'  => 1,
			'created'  => '2009-12-14 00:57:33',
			'modified'  => '2009-12-14 00:57:33'
		));
		$this->assertEqual($results, $expected);
	}
}
?>
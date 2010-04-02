<?php 
/* SVN FILE: $Id$ */
/* WikiPage Test cases generated on: 2010-02-14 18:13:22 : 1266189202*/
App::import('Model', 'WikiPage');

class WikiPageTestCase extends CakeTestCase {
	var $WikiPage = null;
	var $fixtures = array('app.wiki_page', 'app.wiki', 'app.creator', 'app.modifier', 'app.wiki_content', 'app.wiki', 'app.wiki_content_version');

	function startTest() {
		$this->WikiPage =& ClassRegistry::init('WikiPage');
	}

	function testWikiPageInstance() {
		$this->assertTrue(is_a($this->WikiPage, 'WikiPage'));
	}

	function testWikiPageFind() {
		$this->WikiPage->recursive = -1;
		$results = $this->WikiPage->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('WikiPage' => array(
			'id'  => 1,
			'title'  => 'Lorem ipsum dolor sit amet',
			'wiki_id'  => 1,
			'creator_id'  => 1,
			'modifier_id'  => 1,
			'created'  => '2010-02-14 18:13:20',
			'modified'  => '2010-02-14 18:13:20'
		));
		$this->assertEqual($results, $expected);
	}
}
?>
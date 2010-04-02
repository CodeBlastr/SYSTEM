<?php 
/* SVN FILE: $Id$ */
/* WikiPagesTag Test cases generated on: 2010-02-14 18:15:23 : 1266189323*/
App::import('Model', 'WikiPagesTag');

class WikiPagesTagTestCase extends CakeTestCase {
	var $WikiPagesTag = null;
	var $fixtures = array('app.wiki_pages_tag', 'app.tag', 'app.wiki_page');

	function startTest() {
		$this->WikiPagesTag =& ClassRegistry::init('WikiPagesTag');
	}

	function testWikiPagesTagInstance() {
		$this->assertTrue(is_a($this->WikiPagesTag, 'WikiPagesTag'));
	}

	function testWikiPagesTagFind() {
		$this->WikiPagesTag->recursive = -1;
		$results = $this->WikiPagesTag->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('WikiPagesTag' => array(
			'id'  => 1,
			'tag_id'  => 1,
			'wiki_page_id'  => 1,
			'created'  => '2010-02-14 18:15:23',
			'modified'  => '2010-02-14 18:15:23'
		));
		$this->assertEqual($results, $expected);
	}
}
?>
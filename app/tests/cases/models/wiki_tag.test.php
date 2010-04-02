<?php 
/* SVN FILE: $Id$ */
/* WikiTag Test cases generated on: 2009-12-14 01:03:42 : 1260770622*/
App::import('Model', 'WikiTag');

class WikiTagTestCase extends CakeTestCase {
	var $WikiTag = null;
	var $fixtures = array('app.wiki_tag', 'app.tag', 'app.wiki_page');

	function startTest() {
		$this->WikiTag =& ClassRegistry::init('WikiTag');
	}

	function testWikiTagInstance() {
		$this->assertTrue(is_a($this->WikiTag, 'WikiTag'));
	}

	function testWikiTagFind() {
		$this->WikiTag->recursive = -1;
		$results = $this->WikiTag->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('WikiTag' => array(
			'id'  => 1,
			'tag_id'  => 1,
			'wiki_page_id'  => 1,
			'created'  => '2009-12-14 01:03:42',
			'modified'  => '2009-12-14 01:03:42'
		));
		$this->assertEqual($results, $expected);
	}
}
?>
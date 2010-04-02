<?php 
/* SVN FILE: $Id$ */
/* WikisTag Test cases generated on: 2010-02-14 17:57:41 : 1266188261*/
App::import('Model', 'WikisTag');

class WikisTagTestCase extends CakeTestCase {
	var $WikisTag = null;
	var $fixtures = array('app.wikis_tag', 'app.tag', 'app.wiki_page');

	function startTest() {
		$this->WikisTag =& ClassRegistry::init('WikisTag');
	}

	function testWikisTagInstance() {
		$this->assertTrue(is_a($this->WikisTag, 'WikisTag'));
	}

	function testWikisTagFind() {
		$this->WikisTag->recursive = -1;
		$results = $this->WikisTag->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('WikisTag' => array(
			'id'  => 1,
			'tag_id'  => 1,
			'wiki_page_id'  => 1,
			'created'  => '2010-02-14 17:57:41',
			'modified'  => '2010-02-14 17:57:41'
		));
		$this->assertEqual($results, $expected);
	}
}
?>
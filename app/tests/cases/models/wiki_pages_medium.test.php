<?php 
/* SVN FILE: $Id$ */
/* WikiPagesMedium Test cases generated on: 2010-02-14 18:15:00 : 1266189300*/
App::import('Model', 'WikiPagesMedium');

class WikiPagesMediumTestCase extends CakeTestCase {
	var $WikiPagesMedium = null;
	var $fixtures = array('app.wiki_pages_medium', 'app.medium', 'app.wiki_page');

	function startTest() {
		$this->WikiPagesMedium =& ClassRegistry::init('WikiPagesMedium');
	}

	function testWikiPagesMediumInstance() {
		$this->assertTrue(is_a($this->WikiPagesMedium, 'WikiPagesMedium'));
	}

	function testWikiPagesMediumFind() {
		$this->WikiPagesMedium->recursive = -1;
		$results = $this->WikiPagesMedium->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('WikiPagesMedium' => array(
			'id'  => 1,
			'medium_id'  => 1,
			'wiki_page_id'  => 1,
			'created'  => '2010-02-14 18:15:00',
			'modified'  => '2010-02-14 18:15:00'
		));
		$this->assertEqual($results, $expected);
	}
}
?>
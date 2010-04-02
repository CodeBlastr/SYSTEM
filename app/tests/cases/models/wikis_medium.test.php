<?php 
/* SVN FILE: $Id$ */
/* WikisMedium Test cases generated on: 2010-02-14 17:56:11 : 1266188171*/
App::import('Model', 'WikisMedium');

class WikisMediumTestCase extends CakeTestCase {
	var $WikisMedium = null;
	var $fixtures = array('app.wikis_medium', 'app.medium', 'app.wiki_page');

	function startTest() {
		$this->WikisMedium =& ClassRegistry::init('WikisMedium');
	}

	function testWikisMediumInstance() {
		$this->assertTrue(is_a($this->WikisMedium, 'WikisMedium'));
	}

	function testWikisMediumFind() {
		$this->WikisMedium->recursive = -1;
		$results = $this->WikisMedium->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('WikisMedium' => array(
			'id'  => 1,
			'medium_id'  => 1,
			'wiki_page_id'  => 1,
			'created'  => '2010-02-14 17:56:11',
			'modified'  => '2010-02-14 17:56:11'
		));
		$this->assertEqual($results, $expected);
	}
}
?>
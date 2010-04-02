<?php 
/* SVN FILE: $Id$ */
/* WikiMedium Test cases generated on: 2009-12-14 01:03:11 : 1260770591*/
App::import('Model', 'WikiMedium');

class WikiMediumTestCase extends CakeTestCase {
	var $WikiMedium = null;
	var $fixtures = array('app.wiki_medium', 'app.medium', 'app.wiki_page');

	function startTest() {
		$this->WikiMedium =& ClassRegistry::init('WikiMedium');
	}

	function testWikiMediumInstance() {
		$this->assertTrue(is_a($this->WikiMedium, 'WikiMedium'));
	}

	function testWikiMediumFind() {
		$this->WikiMedium->recursive = -1;
		$results = $this->WikiMedium->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('WikiMedium' => array(
			'id'  => 1,
			'medium_id'  => 1,
			'wiki_page_id'  => 1,
			'created'  => '2009-12-14 01:03:11',
			'modified'  => '2009-12-14 01:03:11'
		));
		$this->assertEqual($results, $expected);
	}
}
?>
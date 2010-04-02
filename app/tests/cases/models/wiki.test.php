<?php 
/* SVN FILE: $Id$ */
/* Wiki Test cases generated on: 2010-02-14 18:17:07 : 1266189427*/
App::import('Model', 'Wiki');

class WikiTestCase extends CakeTestCase {
	var $Wiki = null;
	var $fixtures = array('app.wiki', 'app.wiki_page', 'app.creator', 'app.modifier', 'app.wiki_page', 'app.wiki_page');

	function startTest() {
		$this->Wiki =& ClassRegistry::init('Wiki');
	}

	function testWikiInstance() {
		$this->assertTrue(is_a($this->Wiki, 'Wiki'));
	}

	function testWikiFind() {
		$this->Wiki->recursive = -1;
		$results = $this->Wiki->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Wiki' => array(
			'id'  => 1,
			'wiki_page_id'  => 1,
			'public'  => 1,
			'creator_id'  => 1,
			'modifier_id'  => 1,
			'created'  => '2010-02-14 18:17:06',
			'modified'  => '2010-02-14 18:17:06'
		));
		$this->assertEqual($results, $expected);
	}
}
?>
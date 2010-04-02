<?php 
/* SVN FILE: $Id$ */
/* WikiContent Test cases generated on: 2010-02-14 18:09:45 : 1266188985*/
App::import('Model', 'WikiContent');

class WikiContentTestCase extends CakeTestCase {
	var $WikiContent = null;
	var $fixtures = array('app.wiki_content', 'app.wiki_page', 'app.creator', 'app.modifier');

	function startTest() {
		$this->WikiContent =& ClassRegistry::init('WikiContent');
	}

	function testWikiContentInstance() {
		$this->assertTrue(is_a($this->WikiContent, 'WikiContent'));
	}

	function testWikiContentFind() {
		$this->WikiContent->recursive = -1;
		$results = $this->WikiContent->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('WikiContent' => array(
			'id'  => 1,
			'text'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'comments'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'version'  => 1,
			'wiki_page_id'  => 1,
			'creator_id'  => 1,
			'modifier_id'  => 1,
			'created'  => '2010-02-14 18:09:43',
			'modified'  => '2010-02-14 18:09:43'
		));
		$this->assertEqual($results, $expected);
	}
}
?>
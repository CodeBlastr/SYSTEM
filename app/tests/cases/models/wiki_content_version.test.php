<?php 
/* SVN FILE: $Id$ */
/* WikiContentVersion Test cases generated on: 2010-02-14 18:08:49 : 1266188929*/
App::import('Model', 'WikiContentVersion');

class WikiContentVersionTestCase extends CakeTestCase {
	var $WikiContentVersion = null;
	var $fixtures = array('app.wiki_content_version', 'app.wiki_page', 'app.creator', 'app.modifier');

	function startTest() {
		$this->WikiContentVersion =& ClassRegistry::init('WikiContentVersion');
	}

	function testWikiContentVersionInstance() {
		$this->assertTrue(is_a($this->WikiContentVersion, 'WikiContentVersion'));
	}

	function testWikiContentVersionFind() {
		$this->WikiContentVersion->recursive = -1;
		$results = $this->WikiContentVersion->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('WikiContentVersion' => array(
			'id'  => 1,
			'text'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'comments'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'version'  => 1,
			'wiki_page_id'  => 1,
			'creator_id'  => 1,
			'modifier_id'  => 1,
			'created'  => '2010-02-14 18:08:41',
			'modified'  => '2010-02-14 18:08:41'
		));
		$this->assertEqual($results, $expected);
	}
}
?>
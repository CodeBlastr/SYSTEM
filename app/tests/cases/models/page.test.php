<?php 
/* SVN FILE: $Id$ */
/* Page Test cases generated on: 2009-12-14 00:56:01 : 1260770161*/
App::import('Model', 'Page');

class PageTestCase extends CakeTestCase {
	var $Page = null;
	var $fixtures = array('app.page', 'app.user', 'app.user_group', 'app.page_history', 'app.page_medium', 'app.page_tag', 'app.page_user_group');

	function startTest() {
		$this->Page =& ClassRegistry::init('Page');
	}

	function testPageInstance() {
		$this->assertTrue(is_a($this->Page, 'Page'));
	}

	function testPageFind() {
		$this->Page->recursive = -1;
		$results = $this->Page->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Page' => array(
			'id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'title'  => 'Lorem ipsum dolor sit amet',
			'alias'  => 'Lorem ipsum dolor sit amet',
			'content'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'start_date'  => '2009-12-14 00:56:01',
			'end_date'  => '2009-12-14 00:56:01',
			'published'  => 1,
			'keywords'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'description'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'user_id'  => 1,
			'user_group_id'  => 1,
			'created'  => '2009-12-14 00:56:01',
			'modified'  => '2009-12-14 00:56:01'
		));
		$this->assertEqual($results, $expected);
	}
}
?>
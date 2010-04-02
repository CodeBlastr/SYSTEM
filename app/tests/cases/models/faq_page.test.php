<?php 
/* SVN FILE: $Id$ */
/* FaqPage Test cases generated on: 2009-12-14 00:45:00 : 1260769500*/
App::import('Model', 'FaqPage');

class FaqPageTestCase extends CakeTestCase {
	var $FaqPage = null;
	var $fixtures = array('app.faq_page', 'app.user', 'app.faq', 'app.faq_item', 'app.faq_medium', 'app.faq_page_tag', 'app.faq_user_group');

	function startTest() {
		$this->FaqPage =& ClassRegistry::init('FaqPage');
	}

	function testFaqPageInstance() {
		$this->assertTrue(is_a($this->FaqPage, 'FaqPage'));
	}

	function testFaqPageFind() {
		$this->FaqPage->recursive = -1;
		$results = $this->FaqPage->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('FaqPage' => array(
			'id'  => 1,
			'title'  => 'Lorem ipsum dolor sit amet',
			'introduction'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'conclusion'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'public'  => 1,
			'user_id'  => 1,
			'faq_id'  => 1,
			'created'  => '2009-12-14 00:45:00',
			'modified'  => '2009-12-14 00:45:00'
		));
		$this->assertEqual($results, $expected);
	}
}
?>
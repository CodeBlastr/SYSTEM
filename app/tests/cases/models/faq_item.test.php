<?php 
/* SVN FILE: $Id$ */
/* FaqItem Test cases generated on: 2009-12-14 00:44:18 : 1260769458*/
App::import('Model', 'FaqItem');

class FaqItemTestCase extends CakeTestCase {
	var $FaqItem = null;
	var $fixtures = array('app.faq_item', 'app.user', 'app.faq_page');

	function startTest() {
		$this->FaqItem =& ClassRegistry::init('FaqItem');
	}

	function testFaqItemInstance() {
		$this->assertTrue(is_a($this->FaqItem, 'FaqItem'));
	}

	function testFaqItemFind() {
		$this->FaqItem->recursive = -1;
		$results = $this->FaqItem->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('FaqItem' => array(
			'id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'description'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'user_id'  => 1,
			'faq_page_id'  => 1,
			'created'  => '2009-12-14 00:44:18',
			'modified'  => '2009-12-14 00:44:18'
		));
		$this->assertEqual($results, $expected);
	}
}
?>
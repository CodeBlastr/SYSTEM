<?php 
/* SVN FILE: $Id$ */
/* FaqPageTag Test cases generated on: 2009-12-14 00:44:41 : 1260769481*/
App::import('Model', 'FaqPageTag');

class FaqPageTagTestCase extends CakeTestCase {
	var $FaqPageTag = null;
	var $fixtures = array('app.faq_page_tag', 'app.tag', 'app.faq_page');

	function startTest() {
		$this->FaqPageTag =& ClassRegistry::init('FaqPageTag');
	}

	function testFaqPageTagInstance() {
		$this->assertTrue(is_a($this->FaqPageTag, 'FaqPageTag'));
	}

	function testFaqPageTagFind() {
		$this->FaqPageTag->recursive = -1;
		$results = $this->FaqPageTag->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('FaqPageTag' => array(
			'id'  => 1,
			'tag_id'  => 1,
			'faq_page_id'  => 1,
			'created'  => '2009-12-14 00:44:41',
			'modified'  => '2009-12-14 00:44:41'
		));
		$this->assertEqual($results, $expected);
	}
}
?>
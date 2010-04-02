<?php 
/* SVN FILE: $Id$ */
/* FaqMedium Test cases generated on: 2009-12-14 00:44:29 : 1260769469*/
App::import('Model', 'FaqMedium');

class FaqMediumTestCase extends CakeTestCase {
	var $FaqMedium = null;
	var $fixtures = array('app.faq_medium', 'app.medium', 'app.faq_page');

	function startTest() {
		$this->FaqMedium =& ClassRegistry::init('FaqMedium');
	}

	function testFaqMediumInstance() {
		$this->assertTrue(is_a($this->FaqMedium, 'FaqMedium'));
	}

	function testFaqMediumFind() {
		$this->FaqMedium->recursive = -1;
		$results = $this->FaqMedium->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('FaqMedium' => array(
			'id'  => 1,
			'medium_id'  => 1,
			'faq_page_id'  => 1,
			'created'  => '2009-12-14 00:44:29',
			'modified'  => '2009-12-14 00:44:29'
		));
		$this->assertEqual($results, $expected);
	}
}
?>
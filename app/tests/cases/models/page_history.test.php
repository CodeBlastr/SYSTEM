<?php 
/* SVN FILE: $Id$ */
/* PageHistory Test cases generated on: 2009-12-14 00:55:09 : 1260770109*/
App::import('Model', 'PageHistory');

class PageHistoryTestCase extends CakeTestCase {
	var $PageHistory = null;
	var $fixtures = array('app.page_history', 'app.user', 'app.page');

	function startTest() {
		$this->PageHistory =& ClassRegistry::init('PageHistory');
	}

	function testPageHistoryInstance() {
		$this->assertTrue(is_a($this->PageHistory, 'PageHistory'));
	}

	function testPageHistoryFind() {
		$this->PageHistory->recursive = -1;
		$results = $this->PageHistory->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('PageHistory' => array(
			'id'  => 1,
			'description'  => 'Lorem ipsum dolor sit amet',
			'user_id'  => 1,
			'page_id'  => 1,
			'created'  => '2009-12-14 00:55:09',
			'modified'  => '2009-12-14 00:55:09'
		));
		$this->assertEqual($results, $expected);
	}
}
?>
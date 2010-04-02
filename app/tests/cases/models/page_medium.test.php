<?php 
/* SVN FILE: $Id$ */
/* PageMedium Test cases generated on: 2009-12-14 00:55:17 : 1260770117*/
App::import('Model', 'PageMedium');

class PageMediumTestCase extends CakeTestCase {
	var $PageMedium = null;
	var $fixtures = array('app.page_medium', 'app.medium', 'app.page');

	function startTest() {
		$this->PageMedium =& ClassRegistry::init('PageMedium');
	}

	function testPageMediumInstance() {
		$this->assertTrue(is_a($this->PageMedium, 'PageMedium'));
	}

	function testPageMediumFind() {
		$this->PageMedium->recursive = -1;
		$results = $this->PageMedium->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('PageMedium' => array(
			'id'  => 1,
			'medium_id'  => 1,
			'page_id'  => 1,
			'created'  => '2009-12-14 00:55:17',
			'modified'  => '2009-12-14 00:55:17'
		));
		$this->assertEqual($results, $expected);
	}
}
?>
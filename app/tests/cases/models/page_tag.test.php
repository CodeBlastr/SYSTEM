<?php 
/* SVN FILE: $Id$ */
/* PageTag Test cases generated on: 2009-12-14 00:55:27 : 1260770127*/
App::import('Model', 'PageTag');

class PageTagTestCase extends CakeTestCase {
	var $PageTag = null;
	var $fixtures = array('app.page_tag', 'app.tag', 'app.page');

	function startTest() {
		$this->PageTag =& ClassRegistry::init('PageTag');
	}

	function testPageTagInstance() {
		$this->assertTrue(is_a($this->PageTag, 'PageTag'));
	}

	function testPageTagFind() {
		$this->PageTag->recursive = -1;
		$results = $this->PageTag->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('PageTag' => array(
			'id'  => 1,
			'tag_id'  => 1,
			'page_id'  => 1,
			'created'  => '2009-12-14 00:55:27',
			'modified'  => '2009-12-14 00:55:27'
		));
		$this->assertEqual($results, $expected);
	}
}
?>
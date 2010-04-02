<?php 
/* SVN FILE: $Id$ */
/* CatalogTag Test cases generated on: 2009-12-14 00:17:19 : 1260767839*/
App::import('Model', 'CatalogTag');

class CatalogTagTestCase extends CakeTestCase {
	var $CatalogTag = null;
	var $fixtures = array('app.catalog_tag', 'app.tag', 'app.catalog');

	function startTest() {
		$this->CatalogTag =& ClassRegistry::init('CatalogTag');
	}

	function testCatalogTagInstance() {
		$this->assertTrue(is_a($this->CatalogTag, 'CatalogTag'));
	}

	function testCatalogTagFind() {
		$this->CatalogTag->recursive = -1;
		$results = $this->CatalogTag->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('CatalogTag' => array(
			'id'  => 1,
			'tag_id'  => 1,
			'catalog_id'  => 1,
			'created'  => '2009-12-14 00:17:19',
			'modified'  => '2009-12-14 00:17:19'
		));
		$this->assertEqual($results, $expected);
	}
}
?>
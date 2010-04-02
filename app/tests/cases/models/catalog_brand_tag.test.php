<?php 
/* SVN FILE: $Id$ */
/* CatalogBrandTag Test cases generated on: 2009-12-14 00:03:12 : 1260766992*/
App::import('Model', 'CatalogBrandTag');

class CatalogBrandTagTestCase extends CakeTestCase {
	var $CatalogBrandTag = null;
	var $fixtures = array('app.catalog_brand_tag', 'app.tag', 'app.catalog_brand');

	function startTest() {
		$this->CatalogBrandTag =& ClassRegistry::init('CatalogBrandTag');
	}

	function testCatalogBrandTagInstance() {
		$this->assertTrue(is_a($this->CatalogBrandTag, 'CatalogBrandTag'));
	}

	function testCatalogBrandTagFind() {
		$this->CatalogBrandTag->recursive = -1;
		$results = $this->CatalogBrandTag->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('CatalogBrandTag' => array(
			'id'  => 1,
			'tag_id'  => 1,
			'catalog_brand_id'  => 1,
			'created'  => '2009-12-14 00:03:12',
			'modified'  => '2009-12-14 00:03:12'
		));
		$this->assertEqual($results, $expected);
	}
}
?>
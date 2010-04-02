<?php 
/* SVN FILE: $Id$ */
/* CatalogBrand Test cases generated on: 2009-12-14 00:03:54 : 1260767034*/
App::import('Model', 'CatalogBrand');

class CatalogBrandTestCase extends CakeTestCase {
	var $CatalogBrand = null;
	var $fixtures = array('app.catalog_brand', 'app.parent', 'app.user', 'app.catalog_brand_medium', 'app.catalog_brand_tag', 'app.catalog_brand_user_group', 'app.catalog_item');

	function startTest() {
		$this->CatalogBrand =& ClassRegistry::init('CatalogBrand');
	}

	function testCatalogBrandInstance() {
		$this->assertTrue(is_a($this->CatalogBrand, 'CatalogBrand'));
	}

	function testCatalogBrandFind() {
		$this->CatalogBrand->recursive = -1;
		$results = $this->CatalogBrand->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('CatalogBrand' => array(
			'id'  => 1,
			'parent_id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'user_id'  => 1,
			'created'  => '2009-12-14 00:03:54',
			'modified'  => '2009-12-14 00:03:54'
		));
		$this->assertEqual($results, $expected);
	}
}
?>
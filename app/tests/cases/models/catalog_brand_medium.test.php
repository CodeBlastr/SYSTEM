<?php 
/* SVN FILE: $Id$ */
/* CatalogBrandMedium Test cases generated on: 2009-12-14 00:02:53 : 1260766973*/
App::import('Model', 'CatalogBrandMedium');

class CatalogBrandMediumTestCase extends CakeTestCase {
	var $CatalogBrandMedium = null;
	var $fixtures = array('app.catalog_brand_medium', 'app.medium', 'app.catalog_brand');

	function startTest() {
		$this->CatalogBrandMedium =& ClassRegistry::init('CatalogBrandMedium');
	}

	function testCatalogBrandMediumInstance() {
		$this->assertTrue(is_a($this->CatalogBrandMedium, 'CatalogBrandMedium'));
	}

	function testCatalogBrandMediumFind() {
		$this->CatalogBrandMedium->recursive = -1;
		$results = $this->CatalogBrandMedium->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('CatalogBrandMedium' => array(
			'id'  => 1,
			'medium_id'  => 1,
			'catalog_brand_id'  => 1,
			'created'  => '2009-12-14 00:02:53',
			'modified'  => '2009-12-14 00:02:53'
		));
		$this->assertEqual($results, $expected);
	}
}
?>
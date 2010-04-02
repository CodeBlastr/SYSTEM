<?php 
/* SVN FILE: $Id$ */
/* CatalogItemMedium Test cases generated on: 2009-12-14 00:06:34 : 1260767194*/
App::import('Model', 'CatalogItemMedium');

class CatalogItemMediumTestCase extends CakeTestCase {
	var $CatalogItemMedium = null;
	var $fixtures = array('app.catalog_item_medium', 'app.medium', 'app.catalog_item');

	function startTest() {
		$this->CatalogItemMedium =& ClassRegistry::init('CatalogItemMedium');
	}

	function testCatalogItemMediumInstance() {
		$this->assertTrue(is_a($this->CatalogItemMedium, 'CatalogItemMedium'));
	}

	function testCatalogItemMediumFind() {
		$this->CatalogItemMedium->recursive = -1;
		$results = $this->CatalogItemMedium->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('CatalogItemMedium' => array(
			'id'  => 1,
			'medium_id'  => 1,
			'catalog_item_id'  => 1,
			'created'  => '2009-12-14 00:06:34',
			'modified'  => '2009-12-14 00:06:34'
		));
		$this->assertEqual($results, $expected);
	}
}
?>
<?php 
/* SVN FILE: $Id$ */
/* CatalogMedium Test cases generated on: 2009-12-14 00:16:48 : 1260767808*/
App::import('Model', 'CatalogMedium');

class CatalogMediumTestCase extends CakeTestCase {
	var $CatalogMedium = null;
	var $fixtures = array('app.catalog_medium', 'app.medium', 'app.catalog');

	function startTest() {
		$this->CatalogMedium =& ClassRegistry::init('CatalogMedium');
	}

	function testCatalogMediumInstance() {
		$this->assertTrue(is_a($this->CatalogMedium, 'CatalogMedium'));
	}

	function testCatalogMediumFind() {
		$this->CatalogMedium->recursive = -1;
		$results = $this->CatalogMedium->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('CatalogMedium' => array(
			'id'  => 1,
			'medium_id'  => 1,
			'catalog_id'  => 1,
			'created'  => '2009-12-14 00:16:48',
			'modified'  => '2009-12-14 00:16:48'
		));
		$this->assertEqual($results, $expected);
	}
}
?>
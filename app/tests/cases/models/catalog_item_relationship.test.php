<?php 
/* SVN FILE: $Id$ */
/* CatalogItemRelationship Test cases generated on: 2009-12-14 00:08:12 : 1260767292*/
App::import('Model', 'CatalogItemRelationship');

class CatalogItemRelationshipTestCase extends CakeTestCase {
	var $CatalogItemRelationship = null;
	var $fixtures = array('app.catalog_item_relationship', 'app.catalog_item_relationship_type', 'app.user', 'app.catalog_item', 'app.related_catalog_item');

	function startTest() {
		$this->CatalogItemRelationship =& ClassRegistry::init('CatalogItemRelationship');
	}

	function testCatalogItemRelationshipInstance() {
		$this->assertTrue(is_a($this->CatalogItemRelationship, 'CatalogItemRelationship'));
	}

	function testCatalogItemRelationshipFind() {
		$this->CatalogItemRelationship->recursive = -1;
		$results = $this->CatalogItemRelationship->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('CatalogItemRelationship' => array(
			'id'  => 1,
			'catalog_item_relationship_type_id'  => 1,
			'user_id'  => 1,
			'catalog_item_id'  => 1,
			'related_catalog_item_id'  => 1,
			'created'  => '2009-12-14 00:08:12',
			'modified'  => '2009-12-14 00:08:12'
		));
		$this->assertEqual($results, $expected);
	}
}
?>
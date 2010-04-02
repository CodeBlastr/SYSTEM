<?php 
/* SVN FILE: $Id$ */
/* CatalogItemRelationshipType Test cases generated on: 2009-12-14 00:07:18 : 1260767238*/
App::import('Model', 'CatalogItemRelationshipType');

class CatalogItemRelationshipTypeTestCase extends CakeTestCase {
	var $CatalogItemRelationshipType = null;
	var $fixtures = array('app.catalog_item_relationship_type', 'app.catalog_item_relationship');

	function startTest() {
		$this->CatalogItemRelationshipType =& ClassRegistry::init('CatalogItemRelationshipType');
	}

	function testCatalogItemRelationshipTypeInstance() {
		$this->assertTrue(is_a($this->CatalogItemRelationshipType, 'CatalogItemRelationshipType'));
	}

	function testCatalogItemRelationshipTypeFind() {
		$this->CatalogItemRelationshipType->recursive = -1;
		$results = $this->CatalogItemRelationshipType->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('CatalogItemRelationshipType' => array(
			'id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'description'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'created'  => '2009-12-14 00:07:18',
			'modified'  => '2009-12-14 00:07:18'
		));
		$this->assertEqual($results, $expected);
	}
}
?>
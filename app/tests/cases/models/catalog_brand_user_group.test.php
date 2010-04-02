<?php 
/* SVN FILE: $Id$ */
/* CatalogBrandUserGroup Test cases generated on: 2009-12-14 00:03:27 : 1260767007*/
App::import('Model', 'CatalogBrandUserGroup');

class CatalogBrandUserGroupTestCase extends CakeTestCase {
	var $CatalogBrandUserGroup = null;
	var $fixtures = array('app.catalog_brand_user_group', 'app.user_group', 'app.catalog_brand');

	function startTest() {
		$this->CatalogBrandUserGroup =& ClassRegistry::init('CatalogBrandUserGroup');
	}

	function testCatalogBrandUserGroupInstance() {
		$this->assertTrue(is_a($this->CatalogBrandUserGroup, 'CatalogBrandUserGroup'));
	}

	function testCatalogBrandUserGroupFind() {
		$this->CatalogBrandUserGroup->recursive = -1;
		$results = $this->CatalogBrandUserGroup->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('CatalogBrandUserGroup' => array(
			'id'  => 1,
			'user_group_id'  => 1,
			'catalog_brand_id'  => 1,
			'created'  => '2009-12-14 00:03:27',
			'modified'  => '2009-12-14 00:03:27'
		));
		$this->assertEqual($results, $expected);
	}
}
?>
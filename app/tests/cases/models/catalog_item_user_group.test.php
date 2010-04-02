<?php 
/* SVN FILE: $Id$ */
/* CatalogItemUserGroup Test cases generated on: 2009-12-14 00:08:44 : 1260767324*/
App::import('Model', 'CatalogItemUserGroup');

class CatalogItemUserGroupTestCase extends CakeTestCase {
	var $CatalogItemUserGroup = null;
	var $fixtures = array('app.catalog_item_user_group', 'app.catalog_item', 'app.user_group');

	function startTest() {
		$this->CatalogItemUserGroup =& ClassRegistry::init('CatalogItemUserGroup');
	}

	function testCatalogItemUserGroupInstance() {
		$this->assertTrue(is_a($this->CatalogItemUserGroup, 'CatalogItemUserGroup'));
	}

	function testCatalogItemUserGroupFind() {
		$this->CatalogItemUserGroup->recursive = -1;
		$results = $this->CatalogItemUserGroup->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('CatalogItemUserGroup' => array(
			'id'  => 1,
			'catalog_item_id'  => 1,
			'user_group_id'  => 1,
			'created'  => '2009-12-14 00:08:44',
			'modified'  => '2009-12-14 00:08:44'
		));
		$this->assertEqual($results, $expected);
	}
}
?>
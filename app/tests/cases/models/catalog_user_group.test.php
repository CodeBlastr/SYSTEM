<?php 
/* SVN FILE: $Id$ */
/* CatalogUserGroup Test cases generated on: 2009-12-14 00:20:10 : 1260768010*/
App::import('Model', 'CatalogUserGroup');

class CatalogUserGroupTestCase extends CakeTestCase {
	var $CatalogUserGroup = null;
	var $fixtures = array('app.catalog_user_group', 'app.catalog', 'app.user_group');

	function startTest() {
		$this->CatalogUserGroup =& ClassRegistry::init('CatalogUserGroup');
	}

	function testCatalogUserGroupInstance() {
		$this->assertTrue(is_a($this->CatalogUserGroup, 'CatalogUserGroup'));
	}

	function testCatalogUserGroupFind() {
		$this->CatalogUserGroup->recursive = -1;
		$results = $this->CatalogUserGroup->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('CatalogUserGroup' => array(
			'id'  => 1,
			'catalog_id'  => 1,
			'user_group_id'  => 1,
			'created'  => '2009-12-14 00:20:10',
			'modified'  => '2009-12-14 00:20:10'
		));
		$this->assertEqual($results, $expected);
	}
}
?>
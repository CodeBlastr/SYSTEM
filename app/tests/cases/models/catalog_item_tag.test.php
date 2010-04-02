<?php 
/* SVN FILE: $Id$ */
/* CatalogItemTag Test cases generated on: 2009-12-14 00:08:27 : 1260767307*/
App::import('Model', 'CatalogItemTag');

class CatalogItemTagTestCase extends CakeTestCase {
	var $CatalogItemTag = null;
	var $fixtures = array('app.catalog_item_tag', 'app.tag', 'app.catalog_item');

	function startTest() {
		$this->CatalogItemTag =& ClassRegistry::init('CatalogItemTag');
	}

	function testCatalogItemTagInstance() {
		$this->assertTrue(is_a($this->CatalogItemTag, 'CatalogItemTag'));
	}

	function testCatalogItemTagFind() {
		$this->CatalogItemTag->recursive = -1;
		$results = $this->CatalogItemTag->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('CatalogItemTag' => array(
			'id'  => 1,
			'tag_id'  => 1,
			'catalog_item_id'  => 1,
			'created'  => '2009-12-14 00:08:27',
			'modified'  => '2009-12-14 00:08:27'
		));
		$this->assertEqual($results, $expected);
	}
}
?>
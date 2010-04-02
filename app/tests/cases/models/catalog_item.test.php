<?php 
/* SVN FILE: $Id$ */
/* CatalogItem Test cases generated on: 2009-12-14 00:12:49 : 1260767569*/
App::import('Model', 'CatalogItem');

class CatalogItemTestCase extends CakeTestCase {
	var $CatalogItem = null;
	var $fixtures = array('app.catalog_item', 'app.user', 'app.catalog_brand', 'app.catalog', 'app.catalog_item_medium', 'app.catalog_item_relationship', 'app.catalog_item_tag', 'app.catalog_item_user_group', 'app.order_item');

	function startTest() {
		$this->CatalogItem =& ClassRegistry::init('CatalogItem');
	}

	function testCatalogItemInstance() {
		$this->assertTrue(is_a($this->CatalogItem, 'CatalogItem'));
	}

	function testCatalogItemFind() {
		$this->CatalogItem->recursive = -1;
		$results = $this->CatalogItem->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('CatalogItem' => array(
			'id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'alias'  => 'Lorem ipsum dolor sit amet',
			'price'  => 'Lorem ipsum dolor sit amet',
			'summary'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'introduction'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'description'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'additional'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'start_date'  => '2009-12-14 00:12:49',
			'end_date'  => '2009-12-14 00:12:49',
			'published'  => 1,
			'user_id'  => 1,
			'catalog_brand_id'  => 1,
			'catalog_id'  => 1,
			'created'  => '2009-12-14 00:12:49',
			'modified'  => '2009-12-14 00:12:49'
		));
		$this->assertEqual($results, $expected);
	}
}
?>
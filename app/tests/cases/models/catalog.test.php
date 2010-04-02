<?php 
/* SVN FILE: $Id$ */
/* Catalog Test cases generated on: 2009-12-14 00:21:01 : 1260768061*/
App::import('Model', 'Catalog');

class CatalogTestCase extends CakeTestCase {
	var $Catalog = null;
	var $fixtures = array('app.catalog', 'app.parent', 'app.user', 'app.catalog_item', 'app.catalog_medium', 'app.catalog_tag', 'app.catalog_user_group');

	function startTest() {
		$this->Catalog =& ClassRegistry::init('Catalog');
	}

	function testCatalogInstance() {
		$this->assertTrue(is_a($this->Catalog, 'Catalog'));
	}

	function testCatalogFind() {
		$this->Catalog->recursive = -1;
		$results = $this->Catalog->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Catalog' => array(
			'id'  => 1,
			'parent_id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'alias'  => 'Lorem ipsum dolor sit amet',
			'summary'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'introduction'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'description'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'additional'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'start_date'  => '2009-12-14 00:21:01',
			'end_date'  => '2009-12-14 00:21:01',
			'published'  => 1,
			'user_id'  => 1,
			'created'  => '2009-12-14 00:21:01',
			'modified'  => '2009-12-14 00:21:01'
		));
		$this->assertEqual($results, $expected);
	}
}
?>
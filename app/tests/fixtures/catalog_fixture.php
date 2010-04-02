<?php 
/* SVN FILE: $Id$ */
/* Catalog Fixture generated on: 2009-12-14 00:21:01 : 1260768061*/

class CatalogFixture extends CakeTestFixture {
	var $name = 'Catalog';
	var $table = 'catalogs';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'parent_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'name' => array('type'=>'string', 'null' => false, 'default' => NULL),
		'alias' => array('type'=>'string', 'null' => false, 'default' => NULL),
		'summary' => array('type'=>'text', 'null' => false, 'default' => NULL),
		'introduction' => array('type'=>'text', 'null' => false, 'default' => NULL),
		'description' => array('type'=>'text', 'null' => false, 'default' => NULL),
		'additional' => array('type'=>'text', 'null' => false, 'default' => NULL),
		'start_date' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'end_date' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'published' => array('type'=>'boolean', 'null' => false, 'default' => NULL),
		'user_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
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
}
?>
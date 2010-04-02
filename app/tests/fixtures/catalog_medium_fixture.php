<?php 
/* SVN FILE: $Id$ */
/* CatalogMedium Fixture generated on: 2009-12-14 00:16:48 : 1260767808*/

class CatalogMediumFixture extends CakeTestFixture {
	var $name = 'CatalogMedium';
	var $table = 'catalog_media';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'medium_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'catalog_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'medium_id'  => 1,
		'catalog_id'  => 1,
		'created'  => '2009-12-14 00:16:48',
		'modified'  => '2009-12-14 00:16:48'
	));
}
?>
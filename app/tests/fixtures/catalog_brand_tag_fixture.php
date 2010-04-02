<?php 
/* SVN FILE: $Id$ */
/* CatalogBrandTag Fixture generated on: 2009-12-14 00:03:12 : 1260766992*/

class CatalogBrandTagFixture extends CakeTestFixture {
	var $name = 'CatalogBrandTag';
	var $table = 'catalog_brand_tags';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'tag_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'catalog_brand_id' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'tag_id'  => 1,
		'catalog_brand_id'  => 1,
		'created'  => '2009-12-14 00:03:12',
		'modified'  => '2009-12-14 00:03:12'
	));
}
?>
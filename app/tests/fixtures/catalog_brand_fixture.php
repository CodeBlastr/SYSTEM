<?php 
/* SVN FILE: $Id$ */
/* CatalogBrand Fixture generated on: 2009-12-14 00:03:54 : 1260767034*/

class CatalogBrandFixture extends CakeTestFixture {
	var $name = 'CatalogBrand';
	var $table = 'catalog_brands';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'parent_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'name' => array('type'=>'string', 'null' => false, 'default' => NULL),
		'user_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'parent_id'  => 1,
		'name'  => 'Lorem ipsum dolor sit amet',
		'user_id'  => 1,
		'created'  => '2009-12-14 00:03:54',
		'modified'  => '2009-12-14 00:03:54'
	));
}
?>
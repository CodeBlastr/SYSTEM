<?php 
/* SVN FILE: $Id$ */
/* CatalogBrandMedium Fixture generated on: 2009-12-14 00:02:53 : 1260766973*/

class CatalogBrandMediumFixture extends CakeTestFixture {
	var $name = 'CatalogBrandMedium';
	var $table = 'catalog_brand_media';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'medium_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'catalog_brand_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'medium_id'  => 1,
		'catalog_brand_id'  => 1,
		'created'  => '2009-12-14 00:02:53',
		'modified'  => '2009-12-14 00:02:53'
	));
}
?>
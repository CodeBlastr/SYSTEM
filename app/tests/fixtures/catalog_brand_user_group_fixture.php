<?php 
/* SVN FILE: $Id$ */
/* CatalogBrandUserGroup Fixture generated on: 2009-12-14 00:03:27 : 1260767007*/

class CatalogBrandUserGroupFixture extends CakeTestFixture {
	var $name = 'CatalogBrandUserGroup';
	var $table = 'catalog_brand_user_groups';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'user_group_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'catalog_brand_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'user_group_id'  => 1,
		'catalog_brand_id'  => 1,
		'created'  => '2009-12-14 00:03:27',
		'modified'  => '2009-12-14 00:03:27'
	));
}
?>
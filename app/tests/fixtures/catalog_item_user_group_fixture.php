<?php 
/* SVN FILE: $Id$ */
/* CatalogItemUserGroup Fixture generated on: 2009-12-14 00:08:44 : 1260767324*/

class CatalogItemUserGroupFixture extends CakeTestFixture {
	var $name = 'CatalogItemUserGroup';
	var $table = 'catalog_item_user_groups';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'catalog_item_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'user_group_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'catalog_item_id'  => 1,
		'user_group_id'  => 1,
		'created'  => '2009-12-14 00:08:44',
		'modified'  => '2009-12-14 00:08:44'
	));
}
?>
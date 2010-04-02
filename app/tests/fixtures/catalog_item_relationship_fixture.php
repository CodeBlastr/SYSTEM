<?php 
/* SVN FILE: $Id$ */
/* CatalogItemRelationship Fixture generated on: 2009-12-14 00:08:12 : 1260767292*/

class CatalogItemRelationshipFixture extends CakeTestFixture {
	var $name = 'CatalogItemRelationship';
	var $table = 'catalog_item_relationships';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'catalog_item_relationship_type_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'user_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'catalog_item_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'related_catalog_item_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'catalog_item_relationship_type_id'  => 1,
		'user_id'  => 1,
		'catalog_item_id'  => 1,
		'related_catalog_item_id'  => 1,
		'created'  => '2009-12-14 00:08:12',
		'modified'  => '2009-12-14 00:08:12'
	));
}
?>
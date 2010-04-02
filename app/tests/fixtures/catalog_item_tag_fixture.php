<?php 
/* SVN FILE: $Id$ */
/* CatalogItemTag Fixture generated on: 2009-12-14 00:08:27 : 1260767307*/

class CatalogItemTagFixture extends CakeTestFixture {
	var $name = 'CatalogItemTag';
	var $table = 'catalog_item_tags';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'tag_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'catalog_item_id' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'tag_id'  => 1,
		'catalog_item_id'  => 1,
		'created'  => '2009-12-14 00:08:27',
		'modified'  => '2009-12-14 00:08:27'
	));
}
?>
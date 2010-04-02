<?php 
/* SVN FILE: $Id$ */
/* InvoiceCatalogItem Fixture generated on: 2009-12-14 00:45:53 : 1260769553*/

class InvoiceCatalogItemFixture extends CakeTestFixture {
	var $name = 'InvoiceCatalogItem';
	var $table = 'invoice_catalog_items';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'quantity' => array('type'=>'float', 'null' => false, 'default' => NULL, 'length' => 10),
		'user_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'invoice_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'catalog_item_id' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'quantity'  => 1,
		'user_id'  => 1,
		'invoice_id'  => 1,
		'catalog_item_id'  => 1,
		'created'  => '2009-12-14 00:45:53',
		'modified'  => '2009-12-14 00:45:53'
	));
}
?>
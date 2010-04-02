<?php 
/* SVN FILE: $Id$ */
/* InvoiceOrderItem Fixture generated on: 2009-12-14 00:46:09 : 1260769569*/

class InvoiceOrderItemFixture extends CakeTestFixture {
	var $name = 'InvoiceOrderItem';
	var $table = 'invoice_order_items';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'user_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'invoice_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'order_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'user_id'  => 1,
		'invoice_id'  => 1,
		'order_id'  => 1,
		'created'  => '2009-12-14 00:46:09',
		'modified'  => '2009-12-14 00:46:09'
	));
}
?>
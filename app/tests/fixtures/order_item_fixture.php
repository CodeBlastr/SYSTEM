<?php 
/* SVN FILE: $Id$ */
/* OrderItem Fixture generated on: 2009-12-14 00:52:46 : 1260769966*/

class OrderItemFixture extends CakeTestFixture {
	var $name = 'OrderItem';
	var $table = 'order_items';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'quantity' => array('type'=>'float', 'null' => false, 'default' => NULL, 'length' => 10),
		'user_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'order_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'catalog_item_id' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'quantity'  => 1,
		'user_id'  => 1,
		'order_id'  => 1,
		'catalog_item_id'  => 1,
		'created'  => '2009-12-14 00:52:46',
		'modified'  => '2009-12-14 00:52:46'
	));
}
?>
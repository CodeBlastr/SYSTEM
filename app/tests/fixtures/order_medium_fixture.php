<?php 
/* SVN FILE: $Id$ */
/* OrderMedium Fixture generated on: 2009-12-14 00:53:05 : 1260769985*/

class OrderMediumFixture extends CakeTestFixture {
	var $name = 'OrderMedium';
	var $table = 'order_media';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'medium_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'order_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'medium_id'  => 1,
		'order_id'  => 1,
		'created'  => '2009-12-14 00:53:05',
		'modified'  => '2009-12-14 00:53:05'
	));
}
?>
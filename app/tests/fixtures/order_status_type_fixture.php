<?php 
/* SVN FILE: $Id$ */
/* OrderStatusType Fixture generated on: 2009-12-14 00:54:04 : 1260770044*/

class OrderStatusTypeFixture extends CakeTestFixture {
	var $name = 'OrderStatusType';
	var $table = 'order_status_types';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type'=>'string', 'null' => false, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'name'  => 'Lorem ipsum dolor sit amet',
		'created'  => '2009-12-14 00:54:04',
		'modified'  => '2009-12-14 00:54:04'
	));
}
?>
<?php 
/* SVN FILE: $Id$ */
/* Order Fixture generated on: 2010-01-03 20:08:08 : 1262567288*/

class OrderFixture extends CakeTestFixture {
	var $name = 'Order';
	var $table = 'orders';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'order_payment_type_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'order_shipping_type_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'order_status_type_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'introduction' => array('type'=>'text', 'null' => false, 'default' => NULL),
		'conclusion' => array('type'=>'text', 'null' => false, 'default' => NULL),
		'assignee_id' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'contact_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'creator_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'modifier_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'order_payment_type_id'  => 1,
		'order_shipping_type_id'  => 1,
		'order_status_type_id'  => 1,
		'introduction'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
		'conclusion'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
		'assignee_id'  => 1,
		'contact_id'  => 1,
		'creator_id'  => 1,
		'modifier_id'  => 1,
		'created'  => '2010-01-03 20:08:08',
		'modified'  => '2010-01-03 20:08:08'
	));
}
?>
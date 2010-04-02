<?php 
/* SVN FILE: $Id$ */
/* OrderCoupon Fixture generated on: 2009-12-14 00:52:22 : 1260769942*/

class OrderCouponFixture extends CakeTestFixture {
	var $name = 'OrderCoupon';
	var $table = 'order_coupons';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'order_coupon_type_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'name' => array('type'=>'string', 'null' => false, 'default' => NULL),
		'discount' => array('type'=>'float', 'null' => false, 'default' => NULL, 'length' => 10),
		'description' => array('type'=>'text', 'null' => false, 'default' => NULL),
		'code' => array('type'=>'string', 'null' => false, 'default' => NULL),
		'start_date' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'end_date' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'published' => array('type'=>'boolean', 'null' => false, 'default' => NULL),
		'user_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'order_coupon_type_id'  => 1,
		'name'  => 'Lorem ipsum dolor sit amet',
		'discount'  => 'Lorem ipsum dolor sit amet',
		'description'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
		'code'  => 'Lorem ipsum dolor sit amet',
		'start_date'  => '2009-12-14 00:52:22',
		'end_date'  => '2009-12-14 00:52:22',
		'published'  => 1,
		'user_id'  => 1,
		'created'  => '2009-12-14 00:52:22',
		'modified'  => '2009-12-14 00:52:22'
	));
}
?>
<?php 
/* SVN FILE: $Id$ */
/* OrderPaymentSetting Fixture generated on: 2009-12-14 00:53:15 : 1260769995*/

class OrderPaymentSettingFixture extends CakeTestFixture {
	var $name = 'OrderPaymentSetting';
	var $table = 'order_payment_settings';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type'=>'string', 'null' => false, 'default' => NULL),
		'value' => array('type'=>'string', 'null' => false, 'default' => NULL),
		'order_payment_type_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'name'  => 'Lorem ipsum dolor sit amet',
		'value'  => 'Lorem ipsum dolor sit amet',
		'order_payment_type_id'  => 1,
		'created'  => '2009-12-14 00:53:15',
		'modified'  => '2009-12-14 00:53:15'
	));
}
?>
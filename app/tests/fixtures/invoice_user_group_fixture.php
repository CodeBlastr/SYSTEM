<?php 
/* SVN FILE: $Id$ */
/* InvoiceUserGroup Fixture generated on: 2009-12-14 00:46:45 : 1260769605*/

class InvoiceUserGroupFixture extends CakeTestFixture {
	var $name = 'InvoiceUserGroup';
	var $table = 'invoice_user_groups';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'user_group_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'invoice_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'user_group_id'  => 1,
		'invoice_id'  => 1,
		'created'  => '2009-12-14 00:46:45',
		'modified'  => '2009-12-14 00:46:45'
	));
}
?>
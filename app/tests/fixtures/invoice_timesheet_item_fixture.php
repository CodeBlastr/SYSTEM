<?php 
/* SVN FILE: $Id$ */
/* InvoiceTimesheetItem Fixture generated on: 2009-12-14 00:46:34 : 1260769594*/

class InvoiceTimesheetItemFixture extends CakeTestFixture {
	var $name = 'InvoiceTimesheetItem';
	var $table = 'invoice_timesheet_items';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'user_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'invoice_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'timesheet_time_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'user_id'  => 1,
		'invoice_id'  => 1,
		'timesheet_time_id'  => 1,
		'created'  => '2009-12-14 00:46:34',
		'modified'  => '2009-12-14 00:46:34'
	));
}
?>
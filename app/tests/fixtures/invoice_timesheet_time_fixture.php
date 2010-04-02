<?php 
/* SVN FILE: $Id$ */
/* InvoiceTimesheetTime Fixture generated on: 2010-01-01 10:08:21 : 1262358501*/

class InvoiceTimesheetTimeFixture extends CakeTestFixture {
	var $name = 'InvoiceTimesheetTime';
	var $table = 'invoice_timesheet_times';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'invoice_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'timesheet_time_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'creator_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'modifier_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'invoice_id'  => 1,
		'timesheet_time_id'  => 1,
		'creator_id'  => 1,
		'modifier_id'  => 1,
		'created'  => '2010-01-01 10:08:21',
		'modified'  => '2010-01-01 10:08:21'
	));
}
?>
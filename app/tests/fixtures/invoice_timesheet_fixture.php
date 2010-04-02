<?php 
/* SVN FILE: $Id$ */
/* InvoiceTimesheet Fixture generated on: 2010-01-02 15:47:47 : 1262465267*/

class InvoiceTimesheetFixture extends CakeTestFixture {
	var $name = 'InvoiceTimesheet';
	var $table = 'invoice_timesheets';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'invoice_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'timesheet_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'creator_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'modifier_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'invoice_id'  => 1,
		'timesheet_id'  => 1,
		'creator_id'  => 1,
		'modifier_id'  => 1,
		'created'  => '2010-01-02 15:47:47',
		'modified'  => '2010-01-02 15:47:47'
	));
}
?>
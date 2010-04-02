<?php 
/* SVN FILE: $Id$ */
/* Timesheet Fixture generated on: 2010-01-10 21:01:45 : 1263175305*/

class TimesheetFixture extends CakeTestFixture {
	var $name = 'Timesheet';
	var $table = 'timesheets';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type'=>'string', 'null' => false, 'default' => NULL),
		'creator_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'modifier_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'name'  => 'Lorem ipsum dolor sit amet',
		'creator_id'  => 1,
		'modifier_id'  => 1,
		'created'  => '2010-01-10 21:01:45',
		'modified'  => '2010-01-10 21:01:45'
	));
}
?>
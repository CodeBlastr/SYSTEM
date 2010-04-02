<?php 
/* SVN FILE: $Id$ */
/* TimesheetTimeRelationship Fixture generated on: 2010-01-03 00:03:27 : 1262495007*/

class TimesheetTimeRelationshipFixture extends CakeTestFixture {
	var $name = 'TimesheetTimeRelationship';
	var $table = 'timesheet_time_relationships';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'timesheet_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'timesheet_time_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'timesheet_id'  => 1,
		'timesheet_time_id'  => 1,
		'created'  => '2010-01-03 00:03:27',
		'modified'  => '2010-01-03 00:03:27'
	));
}
?>
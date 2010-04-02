<?php 
/* SVN FILE: $Id$ */
/* TimesheetRate Fixture generated on: 2009-12-14 01:00:41 : 1260770441*/

class TimesheetRateFixture extends CakeTestFixture {
	var $name = 'TimesheetRate';
	var $table = 'timesheet_rates';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'cost' => array('type'=>'float', 'null' => false, 'default' => NULL, 'length' => 10),
		'wholesale' => array('type'=>'float', 'null' => false, 'default' => NULL, 'length' => 10),
		'retail' => array('type'=>'float', 'null' => false, 'default' => NULL, 'length' => 10),
		'user_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'cost'  => 1,
		'wholesale'  => 1,
		'retail'  => 1,
		'user_id'  => 1,
		'created'  => '2009-12-14 01:00:41',
		'modified'  => '2009-12-14 01:00:41'
	));
}
?>
<?php 
/* SVN FILE: $Id$ */
/* TimesheetTime Fixture generated on: 2010-01-03 20:35:21 : 1262568921*/

class TimesheetTimeFixture extends CakeTestFixture {
	var $name = 'TimesheetTime';
	var $table = 'timesheet_times';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'hours' => array('type'=>'float', 'null' => false, 'default' => NULL, 'length' => 10),
		'comments' => array('type'=>'text', 'null' => true, 'default' => NULL),
		'started_on' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'project_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'project_issue_id' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'creator_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'modifier_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'hours'  => 1,
		'comments'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
		'started_on'  => '2010-01-03 20:35:21',
		'project_id'  => 1,
		'project_issue_id'  => 1,
		'creator_id'  => 1,
		'modifier_id'  => 1,
		'created'  => '2010-01-03 20:35:21',
		'modified'  => '2010-01-03 20:35:21'
	));
}
?>
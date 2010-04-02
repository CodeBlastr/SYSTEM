<?php 
/* SVN FILE: $Id$ */
/* ProjectTracker Fixture generated on: 2009-12-14 00:57:08 : 1260770228*/

class ProjectTrackerFixture extends CakeTestFixture {
	var $name = 'ProjectTracker';
	var $table = 'project_trackers';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type'=>'string', 'null' => false, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'name'  => 'Lorem ipsum dolor sit amet',
		'created'  => '2009-12-14 00:57:08',
		'modified'  => '2009-12-14 00:57:08'
	));
}
?>
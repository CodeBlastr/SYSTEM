<?php 
/* SVN FILE: $Id$ */
/* ProjectsWatcher Fixture generated on: 2010-01-09 21:30:43 : 1263090643*/

class ProjectsWatcherFixture extends CakeTestFixture {
	var $name = 'ProjectsWatcher';
	var $table = 'projects_watchers';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'contact_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'project_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'creator_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'modifier_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'contact_id'  => 1,
		'project_id'  => 1,
		'creator_id'  => 1,
		'modifier_id'  => 1,
		'created'  => '2010-01-09 21:30:43',
		'modified'  => '2010-01-09 21:30:43'
	));
}
?>
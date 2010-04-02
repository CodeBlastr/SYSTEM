<?php 
/* SVN FILE: $Id$ */
/* ProjectWatcher Fixture generated on: 2009-12-14 00:57:24 : 1260770244*/

class ProjectWatcherFixture extends CakeTestFixture {
	var $name = 'ProjectWatcher';
	var $table = 'project_watchers';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'user_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'contact_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'project_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'user_id'  => 1,
		'contact_id'  => 1,
		'project_id'  => 1,
		'created'  => '2009-12-14 00:57:24',
		'modified'  => '2009-12-14 00:57:24'
	));
}
?>
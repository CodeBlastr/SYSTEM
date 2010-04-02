<?php 
/* SVN FILE: $Id$ */
/* ProjectStatusType Fixture generated on: 2010-01-09 22:04:24 : 1263092664*/

class ProjectStatusTypeFixture extends CakeTestFixture {
	var $name = 'ProjectStatusType';
	var $table = 'project_status_types';
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
		'created'  => '2010-01-09 22:04:24',
		'modified'  => '2010-01-09 22:04:24'
	));
}
?>
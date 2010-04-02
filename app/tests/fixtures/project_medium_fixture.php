<?php 
/* SVN FILE: $Id$ */
/* ProjectMedium Fixture generated on: 2009-12-14 00:56:24 : 1260770184*/

class ProjectMediumFixture extends CakeTestFixture {
	var $name = 'ProjectMedium';
	var $table = 'project_media';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'medium_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'project_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'medium_id'  => 1,
		'project_id'  => 1,
		'created'  => '2009-12-14 00:56:24',
		'modified'  => '2009-12-14 00:56:24'
	));
}
?>
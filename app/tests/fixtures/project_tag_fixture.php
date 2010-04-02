<?php 
/* SVN FILE: $Id$ */
/* ProjectTag Fixture generated on: 2009-12-27 17:06:52 : 1261951612*/

class ProjectTagFixture extends CakeTestFixture {
	var $name = 'ProjectTag';
	var $table = 'project_tags';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'tag_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'project_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'tag_id'  => 1,
		'project_id'  => 1,
		'created'  => '2009-12-27 17:06:52',
		'modified'  => '2009-12-27 17:06:52'
	));
}
?>
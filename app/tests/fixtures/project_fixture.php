<?php 
/* SVN FILE: $Id$ */
/* Project Fixture generated on: 2010-01-03 20:13:10 : 1262567590*/

class ProjectFixture extends CakeTestFixture {
	var $name = 'Project';
	var $table = 'projects';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'parent_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'project_priority_type_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'project_status_type_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'name' => array('type'=>'string', 'null' => false, 'default' => NULL),
		'description' => array('type'=>'text', 'null' => false, 'default' => NULL),
		'public' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'contact_id' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'manager_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'creator_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'modifier_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'parent_id'  => 1,
		'project_priority_type_id'  => 1,
		'project_status_type_id'  => 1,
		'name'  => 'Lorem ipsum dolor sit amet',
		'description'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
		'public'  => 1,
		'contact_id'  => 1,
		'manager_id'  => 1,
		'creator_id'  => 1,
		'modifier_id'  => 1,
		'created'  => '2010-01-03 20:13:10',
		'modified'  => '2010-01-03 20:13:10'
	));
}
?>
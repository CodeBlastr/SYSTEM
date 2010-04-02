<?php 
/* SVN FILE: $Id$ */
/* ProjectIssue Fixture generated on: 2010-01-03 20:19:07 : 1262567947*/

class ProjectIssueFixture extends CakeTestFixture {
	var $name = 'ProjectIssue';
	var $table = 'project_issues';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'parent_id' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 10),
		'lft' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 10),
		'rght' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 10),
		'project_priority_type_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'project_status_type_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'name' => array('type'=>'string', 'null' => false, 'default' => NULL),
		'description' => array('type'=>'text', 'null' => false, 'default' => NULL),
		'start_date' => array('type'=>'date', 'null' => false, 'default' => NULL),
		'due_date' => array('type'=>'date', 'null' => false, 'default' => NULL),
		'estimated_hours' => array('type'=>'float', 'null' => true, 'default' => NULL),
		'done_ratio' => array('type'=>'float', 'null' => true, 'default' => NULL),
		'private' => array('type'=>'boolean', 'null' => false, 'default' => NULL),
		'contact_id' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'assignee_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'project_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'project_tracker_type_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'creator_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'modifier_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'parent_id'  => 1,
		'lft'  => 1,
		'rght'  => 1,
		'project_priority_type_id'  => 1,
		'project_status_type_id'  => 1,
		'name'  => 'Lorem ipsum dolor sit amet',
		'description'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
		'start_date'  => '2010-01-03',
		'due_date'  => '2010-01-03',
		'estimated_hours'  => '2010-01-03',
		'done_ratio'  => '2010-01-03',
		'private'  => 1,
		'contact_id'  => 1,
		'assignee_id'  => 1,
		'project_id'  => 1,
		'project_tracker_type_id'  => 1,
		'creator_id'  => 1,
		'modifier_id'  => 1,
		'created'  => '2010-01-03 20:19:07',
		'modified'  => '2010-01-03 20:19:07'
	));
}
?>
<?php 
/* SVN FILE: $Id$ */
/* ContactTaskMedium Fixture generated on: 2009-12-14 00:40:03 : 1260769203*/

class ContactTaskMediumFixture extends CakeTestFixture {
	var $name = 'ContactTaskMedium';
	var $table = 'contact_task_media';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'medium_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'contact_task_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'medium_id'  => 1,
		'contact_task_id'  => 1,
		'created'  => '2009-12-14 00:40:03',
		'modified'  => '2009-12-14 00:40:03'
	));
}
?>
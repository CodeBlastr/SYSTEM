<?php 
/* SVN FILE: $Id$ */
/* ContactTaskUserGroup Fixture generated on: 2009-12-14 00:42:22 : 1260769342*/

class ContactTaskUserGroupFixture extends CakeTestFixture {
	var $name = 'ContactTaskUserGroup';
	var $table = 'contact_task_user_groups';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'user_group_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'contact_task_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'user_group_id'  => 1,
		'contact_task_id'  => 1,
		'created'  => '2009-12-14 00:42:22',
		'modified'  => '2009-12-14 00:42:22'
	));
}
?>
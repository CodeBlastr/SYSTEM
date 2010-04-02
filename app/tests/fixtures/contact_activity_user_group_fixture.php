<?php 
/* SVN FILE: $Id$ */
/* ContactActivityUserGroup Fixture generated on: 2009-12-14 00:34:01 : 1260768841*/

class ContactActivityUserGroupFixture extends CakeTestFixture {
	var $name = 'ContactActivityUserGroup';
	var $table = 'contact_activity_user_groups';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'user_group_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'contact_activity_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'user_group_id'  => 1,
		'contact_activity_id'  => 1,
		'created'  => '2009-12-14 00:34:01',
		'modified'  => '2009-12-14 00:34:01'
	));
}
?>
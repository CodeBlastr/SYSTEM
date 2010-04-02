<?php 
/* SVN FILE: $Id$ */
/* UserUserGroup Fixture generated on: 2009-12-14 12:23:49 : 1260811429*/

class UserUserGroupFixture extends CakeTestFixture {
	var $name = 'UserUserGroup';
	var $table = 'user_user_groups';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'user_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'user_group_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'user_id'  => 1,
		'user_group_id'  => 1,
		'created'  => '2009-12-14 12:23:49',
		'modified'  => '2009-12-14 12:23:49'
	));
}
?>
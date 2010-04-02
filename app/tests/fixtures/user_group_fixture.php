<?php 
/* SVN FILE: $Id$ */
/* UserGroup Fixture generated on: 2010-01-03 13:19:45 : 1262542785*/

class UserGroupFixture extends CakeTestFixture {
	var $name = 'UserGroup';
	var $table = 'user_groups';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'parent_id' => array('type'=>'integer', 'null' => false, 'default' => '0'),
		'name' => array('type'=>'string', 'null' => false, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'modified' => array('type'=>'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'parent_id'  => 1,
		'name'  => 'Lorem ipsum dolor sit amet',
		'created'  => '2010-01-03 13:19:45',
		'modified'  => '2010-01-03 13:19:45'
	));
}
?>
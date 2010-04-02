<?php 
/* SVN FILE: $Id$ */
/* MediumUserGroup Fixture generated on: 2009-12-14 00:51:51 : 1260769911*/

class MediumUserGroupFixture extends CakeTestFixture {
	var $name = 'MediumUserGroup';
	var $table = 'medium_user_groups';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'user_group_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'media_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'user_group_id'  => 1,
		'media_id'  => 1,
		'created'  => '2009-12-14 00:51:51',
		'modified'  => '2009-12-14 00:51:51'
	));
}
?>
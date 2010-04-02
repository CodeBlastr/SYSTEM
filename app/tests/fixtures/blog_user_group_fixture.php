<?php 
/* SVN FILE: $Id$ */
/* BlogUserGroup Fixture generated on: 2009-12-13 23:58:17 : 1260766697*/

class BlogUserGroupFixture extends CakeTestFixture {
	var $name = 'BlogUserGroup';
	var $table = 'blog_user_groups';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'blog_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'user_group_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'blog_id'  => 1,
		'user_group_id'  => 1,
		'created'  => '2009-12-13 23:58:17',
		'modified'  => '2009-12-13 23:58:17'
	));
}
?>
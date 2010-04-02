<?php 
/* SVN FILE: $Id$ */
/* User Fixture generated on: 2010-01-03 20:40:52 : 1262569252*/

class UserFixture extends CakeTestFixture {
	var $name = 'User';
	var $table = 'users';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'username' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 50, 'key' => 'unique'),
		'password' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 40),
		'last_login' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'user_group_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'contact_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'username' => array('column' => 'username', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'username'  => 'Lorem ipsum dolor sit amet',
		'password'  => 'Lorem ipsum dolor sit amet',
		'last_login'  => '2010-01-03 20:40:52',
		'user_group_id'  => 1,
		'contact_id'  => 1,
		'created'  => '2010-01-03 20:40:52',
		'modified'  => '2010-01-03 20:40:52'
	));
}
?>
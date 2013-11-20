<?php
/**
 * UserRoleFixture
 *
 */
class UserRoleFixture extends CakeTestFixture {
/**
 * Table name
 *
 * @var string
 */
	public $table = 'user_roles';
	
/**
 * Import
 *
 * @var array
 */
	public $import = array('config' => 'Users.UserRole');

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => '3',
			'is_system' => '0',
			'name' => 'users',
			'view_prefix' => '',
			'is_registerable' => 1,
			'created' => '2013-07-21 09:51:58',
			'modified' => '2013-07-21 09:51:58',
			'lft' => 5,
			'rght' => 6
		),
		array(
			'id' => '10',
			'is_system' => '0',
			'name' => 'secret-users',
			'view_prefix' => '',
			'is_registerable' => 0,
			'created' => '2013-07-21 09:51:58',
			'modified' => '2013-07-21 09:51:58',
			'lft' => 9,
			'rght' => 10
		)
	);
}

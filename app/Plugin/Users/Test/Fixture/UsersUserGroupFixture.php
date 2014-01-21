<?php
/**
 * UsersUserGroupFixture
 *
 */
class UsersUserGroupFixture extends CakeTestFixture {
/**
 * Table name
 *
 * @var string
 */
	public $table = 'users_user_groups';
	
/**
 * Import
 *
 * @var array
 */
	public $import = array('config' => 'Users.UsersUserGroup');

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'user_id' => 100,
			'user_group_id' => 1,
			'is_approved' => 1,
			'is_moderator' => 1,

		),
		array(
			'id' => 2,
			'user_id' => 101,
			'user_group_id' => 2,
			'is_approved' => 1,
			'is_moderator' => 1,

		),
	);
}

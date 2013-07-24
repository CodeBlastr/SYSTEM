<?php
/**
 * UserGroupFixture
 *
 */
class UserGroupFixture extends CakeTestFixture {
/**
 * Table name
 *
 * @var string
 */
	public $table = 'user_groups';
	
/**
 * Import
 *
 * @var array
 */
	public $import = array('config' => 'Users.UserGroup');

/**
 * Records
 *
 * @var array
 */
	public $records = array();
}

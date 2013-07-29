<?php
/**
 * UserFixture
 *
 */
class UserFixture extends CakeTestFixture {
	
/**
 * Import
 *
 * @var array
 */
	public $import = array('config' => 'Users.User');

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 100,
			'parent_id' => null,
			'reference_code' => null,
			'full_name' => 'Isaac Newton',
			'first_name' => 'Isaac',
			'last_name' => 'Newton',
			'username' => 'issac.newton',
			'password' => 'd85d8e4e8f1c7e4c91016c200f9c57e13bc8d3a9',
			'email' => 'isaac.newton@razorit.com',
			'view_prefix' => null,
			'zip' => null,
			'last_login' => '1727-03-20 05:32:44',
			'forgot_key' => null,
			'forgot_key_created' => null,
			'forgot_tries' => null,
			'user_role_id' => 3,
			'credit_total' => null,
			'slug' => null,
			'creator_id' => null,
			'modifier_id' => null,
			'created' => '1642-12-25 09:44:22',
			'modified' => '1727-03-20 05:32:44'
		),
		array(
			'id' => 101,
			'parent_id' => null,
			'reference_code' => null,
			'full_name' => 'Dolly Parton',
			'first_name' => 'Dolly',
			'last_name' => 'Parton',
			'username' => 'dolly.parton',
			'password' => 'e85d8e4e8f1c7e4c91016c200f9c57e13bc8d3a9',
			'email' => 'dolly.parton@razorit.com',
			'view_prefix' => null,
			'zip' => null,
			'last_login' => '1927-03-20 05:32:44',
			'forgot_key' => null,
			'forgot_key_created' => null,
			'forgot_tries' => null,
			'user_role_id' => 3,
			'credit_total' => null,
			'slug' => null,
			'creator_id' => null,
			'modifier_id' => null,
			'created' => '1842-12-25 09:44:22',
			'modified' => '1927-03-20 05:32:44'
		),
	);
}

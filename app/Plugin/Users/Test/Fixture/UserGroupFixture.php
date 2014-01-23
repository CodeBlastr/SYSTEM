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
	public $records = array(
		array(
			'id' => 1,
			'title' => 'title',
			'description' => 'this is desc',
			'model' => null,
			'foreign_key' => null,
			'creator_id' => null,
			'modifier_id' => null,
		),
		array(
			'id' => 2,
			'title' => 'title',
			'description' => 'this is desc',
			'model' => null,
			'foreign_key' => null,
			'creator_id' => null,
			'modifier_id' => null,
		),
	);


}

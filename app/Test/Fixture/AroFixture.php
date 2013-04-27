<?php
/**
 * AroFixture
 *
 */
class AroFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'parent_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 10),
		'model' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'foreign_key' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 10),
		'alias' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'lft' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 10),
		'rght' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 10),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'parent_id' => null,
			'model' => 'UserRole',
			'foreign_key' => 1,
			'alias' => null,
			'lft' => 1,
			'rght' => 4
		),
		array(
			'id' => 2,
			'parent_id' => null,
			'model' => 'User',
			'foreign_key' => 42,
			'alias' => null,
			'lft' => 2,
			'rght' => 3
		),
		array(
			'id' => 3,
			'parent_id' => null,
			'model' => 'UserRole',
			'foreign_key' => 2,
			'alias' => null,
			'lft' => 5,
			'rght' => 6
		),
		array(
			'id' => 4,
			'parent_id' => null,
			'model' => 'UserRole',
			'foreign_key' => 3,
			'alias' => null,
			'lft' => 7,
			'rght' => 8
		),
		array(
			'id' => 5,
			'parent_id' => null,
			'model' => 'UserRole',
			'foreign_key' => 5,
			'alias' => null,
			'lft' => 9,
			'rght' => 10
		),
	);
}

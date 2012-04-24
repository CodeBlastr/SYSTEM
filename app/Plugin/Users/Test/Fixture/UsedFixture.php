<?php
/**
 * UsedFixture
 *
 */
class UsedFixture extends CakeTestFixture {
/**
 * Table name
 *
 * @var string
 */
	public $table = 'used';

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'key' => 'index'),
		'foreign_key' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'model' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'role' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'creator_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'modifier_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'USER_RECORDS' => array('column' => array('user_id', 'foreign_key', 'model'), 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => '4f278d40-5670-4f74-80da-0c79124e0d46',
			'user_id' => '3',
			'foreign_key' => '4f278d38-8224-46e5-a9b2-0c79124e0d46',
			'model' => 'Project',
			'role' => 'member',
			'creator_id' => '1',
			'modifier_id' => '1',
			'created' => '2012-01-31 12:12:08',
			'modified' => '2012-01-31 12:12:08'
		),
		array(
			'id' => '4f278d47-c2c8-403f-aa20-0c79124e0d46',
			'user_id' => '2',
			'foreign_key' => '4f278d38-8224-46e5-a9b2-0c79124e0d46',
			'model' => 'Project',
			'role' => 'member',
			'creator_id' => '1',
			'modifier_id' => '1',
			'created' => '2012-01-31 12:12:15',
			'modified' => '2012-01-31 12:12:15'
		),
		array(
			'id' => '4f27b2dd-5c0c-4a58-9f42-053a124e0d46',
			'user_id' => '2',
			'foreign_key' => '4f279de7-3e90-4a5d-b1f4-137a124e0d46',
			'model' => 'Project',
			'role' => 'member',
			'creator_id' => '1',
			'modifier_id' => '1',
			'created' => '2012-01-31 14:52:37',
			'modified' => '2012-01-31 14:52:37'
		),
		array(
			'id' => '4f8c626b-8d0c-4c77-8bc1-1010124e0d46',
			'user_id' => '1',
			'foreign_key' => '4f8c626b-8d0c-4c77-8bc1-1010124e0d46',
			'model' => 'Task',
			'role' => 'member',
			'creator_id' => '1',
			'modifier_id' => '1',
			'created' => '2012-04-19 13:58:38',
			'modified' => '2012-04-19 13:58:38'
		),
		array(
			'id' => '4f9ff6b-8d0c-4c77-8bc1-1010124e0d46',
			'user_id' => '6',
			'foreign_key' => '4f8c626b-8g8c-4c77-8bc1-1010124e0d46',
			'model' => 'Article',
			'role' => 'author',
			'creator_id' => '1',
			'modifier_id' => '1',
			'created' => '2012-04-19 13:58:38',
			'modified' => '2012-04-19 13:58:38'
		),
	);
}

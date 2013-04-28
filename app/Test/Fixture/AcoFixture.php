<?php
/**
 * AcoFixture
 *
 */
class AcoFixture extends CakeTestFixture {
 
 
/**
 * Import
 *
 * @var array
 */
	public $import = array('config' => 'Aco');
	

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'parent_id' => null,
			'model' => null,
			'foreign_key' => null,
			'alias' => 'controllers',
			'lft' => 1,
			'rght' => 4,
			'type' => 'controller',
		),
		array(
			'id' => 2,
			'parent_id' => 1,
			'model' => null,
			'foreign_key' => null,
			'alias' => 'Admin',
			'lft' => 2,
			'rght' => 3,
			'type' => 'controller',
		),
	);
}

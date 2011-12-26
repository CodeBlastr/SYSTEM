<?php
/**
 * Copyright 2009-2010, Cake Development Corporation (http://cakedc.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2009-2010, Cake Development Corporation (http://cakedc.com)
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * favorites Migration 001
 *
 * @package favorites
 * @subpackage favorites.config.migrations
 */
class M659366d4dfg453d4ae1c536ea44ea001 extends CakeMigration {

/**
 * Migration array
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'create_table' => array(
				'favorites' => array(
					'id' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary'),
					'user_id' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 36),
					'foreign_key' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'index'),
					'model' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 64),
					'type' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 32),
					'position' => array('type'=>'integer', 'null' => true, 'default' => '0', 'length' => 3),
					'created' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
					'modified' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1), 
						'UNIQUE_FAVORITES' => array('column' => array('foreign_key', 'model', 'type', 'user_id'), 'unique' => 1))
				),
			),
		),
		'down' => array(
			'drop_table' => array('favorites'))
	);

/**
 * before migration callback
 *
 * @param string $direction, up or down direction of migration process
 */
	public function before($direction) {
		return true;
	}

/**
 * after migration callback
 *
 * @param string $direction, up or down direction of migration process
 */
	public function after($direction) {
		return true;
	}

}
?>
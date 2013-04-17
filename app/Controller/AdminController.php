<?php
App::uses('CakeSchema', 'Model');
/**
 * Admin Dashboard Controller
 *
 * This controller will output variables used for the Admin dashboard.
 * Primarily conceived as the hub for managing the rest of the app.
 *
 * PHP versions 5
 *
 * Zuha(tm) : Business Management Applications (http://zuha.com)
 * Copyright 2009-2012, Zuha Foundation Inc. (http://zuha.org)
 *
 * Licensed under GPL v3 License
 * Must retain the above copyright notice and release modifications publicly.
 *
 * @copyright     Copyright 2009-2012, Zuha Foundation Inc. (http://zuha.com)
 * @link          http://zuha.com Zuha� Project
 * @package       zuha
 * @subpackage    zuha.app.controllers
 * @since         Zuha(tm) v 0.0.1
 * @license       GPL v3 License (http://www.gnu.org/licenses/gpl.html) and Future Versions
 */
class AdminController extends AppController {

/**
 * Name
 * 
 * @var 
 */
	public $name = 'Admin';

/**
 * Uses
 *
 * @var string
 */
    public $uses = array();
	
/**
 * Index method
 * 
 * @param void
 * @return void
 */
    public function index() {
		// $this->Session->delete('Updates');
		// upgrade functionality...
		if (!empty($this->request->data['Upgrade']['all'])) {
			$this->_runUpdates();
			$this->set('runUpdates', true);
		} 
		$complete = $this->Session->read('Updates.complete');
		if (!empty($complete)) {
			$this->Session->delete('Updates'); 
			$this->Session->setFlash(__('Update check complete!!!'));
		}
		$this->set('page_title_for_layout', 'Admin Dashboard');
		$this->layout = 'default';
		
		
		if (in_array('Blogs', CakePlugin::loaded())) {
			App::uses('Blog', 'Blogs.Model');
			$Blog = new Blog();
			$this->set('blogs', $Blog->find('all'));
		}
	}
	
/**
 * Run updates
 *
 * @todo write a test to make sure the plugin returns good values, and that will be a good way to test for whether the plugins array in bootstrap is still good during updates.
 * @todo make it faster somehow... takes about 20 minutes right now  ( this might help... $db->describe($this); )
 */
	protected function _runUpdates() {
		$this->_tempSettings();
		$allTables = $this->_tables();  // all tables and their plugins
		$lastTableWithPlugin = $this->Session->read('Updates.last'); // ex. array('blog_posts' => 'Blogs');
		$lastTable = @array_pop(array_keys($this->Session->read('Updates.last'))); // check the session for the last TABLE run  
		$nextTable = key(array_slice($allTables, array_search($lastTable, array_keys($allTables)) + 1));
		$nextPlugin = !empty($nextTable) ? $allTables[$nextTable] : null;
        $keysOfAllTables = array_keys($allTables);
		$endTable = array_pop($keysOfAllTables); // check the session for the last TABLE run  
		
		
		// Turn on to debug 
//		debug($lastTable);
//		debug($nextTable);
//		debug($nextPlugin); // if false, means its not a plugin
//		debug($endTable);
//		debug($allTables);
//		debug($this->Session->read());
//		break;
		
		if (!$this->Session->read('Updates.upgrade')) {
			// there are some upgrades that have to be hard coded
			$this->_upgrade();
			$this->Session->write('Updates.upgrade', true);
		}
		
		if (!empty($nextPlugin) && !in_array($nextPlugin, CakePlugin::loaded())) { 
			// plugin is not loaded so downgrade
			$this->Session->write('Updates.last', !empty($lastTableWithPlugin) ? array_merge($lastTableWithPlugin, $this->_downgrade($nextTable, $lastTable)) : $this->_downgrade($nextTable, $lastTable));
			return true;
		} elseif ($endTable == $lastTable) {
			// if last TABLE run equals the end then quit and set a session Updates.complete = true and quit
			$this->Session->write('Updates.complete', true);
			$this->_tempSettings(false);
			return true;
		} elseif (empty($lastTable)) {
			// The first time this is running, first time could be a plugin or a core
			$nextTable = key($allTables);
			$nextPlugin = current($allTables);
			if (!empty($nextPlugin)) {
				$update = $this->_runPluginUpate($nextPlugin, $nextTable); // plugin update
			} else {
				$update = $this->_runAppUpate($nextTable); // app update
			}
			$this->Session->write('Updates.last', $update); 
			$this->_tempSettings(false);
			return true;			
		} elseif (!empty($lastTable) && empty($nextPlugin)) {
			// NOT a plugin run the core update and write the session using the table name and status
			$this->Session->write('Updates.last', array_merge($lastTableWithPlugin, $this->_runAppUpate($nextTable))); 
			$this->_tempSettings(false);
			return true;
		} elseif (!empty($lastTable) && !empty($nextPlugin)) {
			// if it is a plugin run the plugin update and write the session using the table name and status
			$this->Session->write('Updates.last', array_merge($lastTableWithPlugin, $this->_runPluginUpate($nextPlugin, $nextTable)));
			$this->_tempSettings(false);
			return true;
		} else {
			break;
			$this->_tempSettings(false);
			break;
			return false; // nothing to do, should never reach this point
		}
	}
	
/**
 * Run app update 
 * 
 */
 	protected function _runAppUpate($table = null) {
		$this->Schema = new CakeSchema(array(
			'path' => null, 
			'file' => false, 
			'connection' => 'default'
			));
		$New = $this->Schema->load();
		return $this->_update($New, $table);
	}
	
/**
 * Run plugin update 
 * 
 */
 	protected function _runPluginUpate($plugin, $table = null) {
		$this->Schema = new CakeSchema(array(
			'name' => $plugin, 
			'path' => null, 
			'file' => false, 
			'connection' => 'default', 
			'plugin' => $plugin
			));				
		$New = $this->Schema->load();
		return $this->_update($New, $table);
	}
	
	
/**
 * Downgrade table method
 *
 * If a plugin table exists but the plugin isn't loaded remove the table. (for now we back it up)
 *
 * @access protected
 * @param string
 * @return array
 * @todo maybe if the table is empty you don't back it up?
 */
	protected function _downgrade($table, $lastTable) {
		$db = ConnectionManager::getDataSource('default');
		$db->cacheSources = false;
		$tableCheck = $db->query('SHOW TABLES LIKE "' . $table . '";');
		
		if (!empty($tableCheck)) {
			try {
				$db->execute('DROP TABLE `zbk_' . $table . '`;'); 
			} catch (PDOException $e) {
				// do nothing, just tried deleting a table that doesn't exist
			} 
			
			if ($db->query('SELECT * FROM `' . $table . '`;')) {
				// backup a table that we're about to delete
				try {
					$db->execute('CREATE TABLE `zbk_' . $table . '` LIKE `' . $table . '`;');
					$db->execute('INSERT INTO `zbk_' . $table . '` SELECT * FROM `' . $table . '`;');
				} catch (PDOException $e) {
					throw new Exception($table . ': ' . $e->getMessage());
				}
			} 
			
			try {
				$db->query('DROP TABLE `' . $table . '`;'); 
				// need the last table, because the table just removed will no longer exist in the tables array
				return array($lastTable => __('AND %s removed', $table));
			} catch (PDOException $e) {
				throw new Exception($table . ': ' . $e->getMessage());
			}
		} else {
			// the table doesn't exist so its already downgrade
			return array($table => __('AND %s was already gone'));
		}
	}
	
	
/**
 * Update method
 *
 * Check if update is needed, if confirmed is true, run the update
 *
 * @access protected
 * @param object
 * @param string
 * @param bool
 * @return mixed
 */
	protected function _update(&$Schema, $table = null, $confirmed = false) {
		$db = ConnectionManager::getDataSource($this->Schema->connection);
		$db->cacheSources = false;

		$options = array();
		if (isset($this->params['force'])) {
			$options['models'] = false;
		}
		
		$Old = $this->Schema->read($options);
		$compare = $this->Schema->compare($Old, $Schema);

		$contents = array();

		if (empty($table)) {
			foreach ($compare as $table => $changes) {
				$contents[$table] = $db->alterSchema(array($table => $changes), $table);
			}
		} else if (isset($compare[$table])) {
			$contents[$table] = $db->alterSchema(array($table => $compare[$table]), $table);
		}

		if (empty($contents)) {
			return array($table => 'up to date'); // its already up to date we
		}
		
		$i = 0;
		foreach($contents as $key => $value) {
			$out[$i]['table'] = $key;
			$out[$i]['queries'] = $value;
			$out[$i]['name'] = $this->Schema->name;
			$out[$i]['plugin'] = $this->Schema->plugin;
			$i = $i + 1;
		}
		//debug($out);  turn on to see queries as they run
		
		if (!empty($this->request->data['Upgrade']['all'])) {
			try {
				return $this->_run($contents, 'update', $Schema);
			} catch (Exception $e) {
				debug($e->getMessage());
				debug('You need to run this update manually.  Probably an unrecognized column type, like enum.');
				break;
			}
		}
		return $out;
	}
	
	

/**
 * Runs sql from _create() or _update()
 *
 * @param array $contents
 * @param string $event
 * @param CakeSchema $Schema
 * @return void
 */
	protected function _run($contents, $event, &$Schema) {
		if (empty($contents)) {
			throw new Exception(__('Sql could not be run'));
		}
		
		Configure::write('debug', 2);
		$db = ConnectionManager::getDataSource($this->Schema->connection);
		foreach ($contents as $table => $sql) {
			if (empty($sql)) {
				return array($table => 'up to date');
			} else {
				if (!$Schema->before(array($event => $table))) {
					debug($table);
					break;
					return false;
				}
				$error = null;
				
				try {
					$db->execute($sql);
				} catch (PDOException $e) {
					$error = $table . ': ' . $e->getMessage();
				}
				$Schema->after(array($event => $table, 'errors' => $error));
				
				if (!empty($error)) {
					throw new Exception($error);
				} else {
					return array($table => 'updated'); // update is run
				}
			}
		}
	}
	
	
/**
 * Tables
 * 
 * A list of all tables, as keys with their corresponding plugin as values
 *
 * @access protected
 * @return array
 */
	protected function _tables() {
		$db = ConnectionManager::getDataSource('default');
		foreach ($db->listSources() as $table) {
			if (strpos($table, 'zbk_') === false) {
				$tables[$table] = ZuhaInflector::pluginize($table);
			}
		}
		return $tables;
	}
	
/** 
 * Temp settings
 * 
 * turns on debug and disables cache, then sets them back to what they were previously
 *
 */
	protected function _tempSettings($start = true) {		
		if (!empty($start)) {
			$this->debug = Configure::read('debug');
			$this->cacheDisable = Configure::read('Cache.disable');
			Configure::write('debug', 2);
			Configure::write('Cache.disable', true);
		} else {
			Configure::write('Cache.disable', $this->cacheDisable);	
			Configure::write('debug', $this->debug);	
		}
	}
	
	
/**
 * Upgrade
 * 
 * Upgrades the database to the latest version.
 *
 * @todo 	 Looks like this upgrade function and the other(s) need to be made into a plugin or core behavior
 */
	protected function _upgrade() {
		$db = ConnectionManager::getDataSource('default');
		$tables = $db->listSources();
		
		// automatic upgrade the categories table 5/8/2012
		if (defined('__SYSTEM_ZUHA_DB_VERSION') && __SYSTEM_ZUHA_DB_VERSION < 0.0192) {
			if (array_search('category_options', $tables)) {
				$db->query('ALTER TABLE `category_options` CHANGE `type` `type` VARCHAR( 100 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT \'Attribute Group\' COMMENT \'\'\'Attribute Group\'\',\'\'Attribute Type\'\',\'\'Option Group\'\',\'\'Option Type\'\'\';');
			}
			if (array_search('form_inputs', $tables)) {
				$db->query('ALTER TABLE `form_inputs` CHANGE `system_default_value` `system_default_value` VARCHAR( 100 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT \'was enum with \'\'current user\'\' as the only option\';');
			}
			if (array_search('form_inputs', $tables)) {
				$db->query('ALTER TABLE `form_inputs` CHANGE `validation` `validation` VARCHAR( 100 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT \'was enum with \'\'email\'\',\'\'number\'\' as values\';');
			}
			if (array_search('order_transactions', $tables)) {
				$db->query('ALTER TABLE `order_transactions` CHANGE `status` `status` VARCHAR( 100 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT \'was enum with \'\'failed\'\',\'\'success\'\',\'\'paid\'\',\'\'pending\'\',\'\'shipped\'\',\'\'frozen\'\',\'\'cancelled\'\' as values\';');
			}
			if (array_search('user_followers', $tables)) {
				$db->query('ALTER TABLE `user_followers` CHANGE `approved` `approved` BOOLEAN NULL DEFAULT NULL COMMENT \'was enum with \'\'0\'\',\'\'1\'\' as values\';');
			}
			if (array_search('webpage_css', $tables)) {
				$db->query('ALTER TABLE `webpage_css` CHANGE `type` `type` VARCHAR( 100 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT \'all\' COMMENT \'was enum with \'\'all\'\',\'\'screen\'\',\'\'print\'\',\'\'handheld\'\',\'\'braille\'\',\'\'embossed\'\',\'\'projection\'\',\'\'speech\'\',\'\'tty\'\',\'\'tv\'\' as values\';');
			}
			if (array_search('webpages', $tables)) {
				$db->query('ALTER TABLE `webpages` CHANGE `type` `type` VARCHAR( 50 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT \'content\' COMMENT \'\'\'template\'\',\'\'element\'\',\'\'content\'\'\';');
			}
		}
		
		if (defined('__SYSTEM_ZUHA_DB_VERSION') && __SYSTEM_ZUHA_DB_VERSION < 0.0192) {
			// eliminate used table duplicates so that the index can be added
			if (array_search('used', $tables)) {
				$db->query('DELETE FROM `used` WHERE `used`.`user_id` IS NULL;');
				$totals = $db->query('SELECT `user_id`, `model`, `foreign_key`, COUNT(*) AS total FROM `used` GROUP BY `user_id`, `foreign_key`, `model` ORDER BY `total` DESC;');
				foreach ($totals as $total) {
					if ($total[0]['total'] > 1) {
						$limit = $total[0]['total'] - 1;
						$db->query('DELETE FROM `used` WHERE `used`.`user_id` = \''.$total['used']['user_id'].'\' AND `used`.`model` = \''.$total['used']['model'].'\' AND `used`.`foreign_key` = \''.$total['used']['foreign_key'].'\'   LIMIT '.$limit.';');
					}
				}
			}
		}	
		
		if (defined('__SYSTEM_ZUHA_DB_VERSION') && __SYSTEM_ZUHA_DB_VERSION < 0.0192) {
			// eliminate used table duplicates so that the index can be added
			if (array_search('user_followers', $tables)) {
				$totals = $db->query('SELECT `id`, COUNT(*) AS total FROM `user_followers` GROUP BY `id` ORDER BY `total` DESC;');
				foreach ($totals as $total) {
					if ($total[0]['total'] > 1) {
						$limit = $total[0]['total'] - 1;
						$db->query('DELETE FROM `user_followers` WHERE `user_followers`.`id` = \''.$total['user_followers']['id'].'\'  LIMIT '.$limit.';');
					}
				}
			}
		}	
	}
	
}
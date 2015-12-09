<?php

App::uses('Component', 'Controller');
App::uses('ZuhaSchema', 'Model');

class SiteUpdateComponent extends Component {

	public $components = array('Session');

	public function initialize(Controller $controller) {
		$this->controller = $controller;
	}

/**
 * @todo write a test to make sure the plugin returns good values, and that will be a good way to test for whether the plugins array in bootstrap is still good during updates.
 */
	public function _runUpdates() {
		$this->_tempSettings();
		$allTables = $this->_tables();  // all tables and their plugins
		$lastTableWithPlugin = $this->Session->read('Updates.last'); // ex. array('blog_posts' => 'Blogs');
		$lastTable = @array_pop(array_keys($this->Session->read('Updates.last'))); // check the session for the last TABLE run
		$nextTable = key(array_slice($allTables, array_search($lastTable, array_keys($allTables)) + 1));
		$nextPlugin = !empty($nextTable) ? $allTables[$nextTable] : null;
		$keysOfAllTables = array_keys($allTables);
		$endTable = array_pop($keysOfAllTables); // check the session for the last TABLE run
		// Turn on to debug
		// debug($lastTable);
		// debug($nextTable);
		// debug($nextPlugin); // if false, means its not a plugin
		// debug(CakePlugin::loaded());
		// debug(CakePlugin::loaded($nextPlugin));
		// debug($endTable);
		// debug($allTables);
		// debug($this->Session->read());
		// exit;
		if (!empty($nextPlugin) && !CakePlugin::loaded($nextPlugin)) {
			// plugin is not loaded so downgrade
			$last = !empty($lastTableWithPlugin) ? array_merge($lastTableWithPlugin, $this->_downgrade($nextTable, $lastTable)) : $this->_downgrade($nextTable, $lastTable);
			// more debugging
			// if ( !empty($lastTableWithPlugin) ) {
			//	 debug($lastTableWithPlugin);
			//	 debug($this->_downgrade($nextTable, $lastTable));
			//	 debug( array_merge($lastTableWithPlugin, $this->_downgrade($nextTable, $lastTable)) );
			//	 die();
			// }
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
			$this->Session->write('Updates.last', array_merge($lastTableWithPlugin, $this->_runPluginUpate($nextPlugin, $nextTable, $lastTable)));
			$this->_tempSettings(false);
			return true;
		} else {
			return false; // nothing to do, should never reach this point
		}
	}

/**
 * @param type $table
 * @return type
 */
	public function _runAppUpate($table = null) {
		$this->Schema = new ZuhaSchema(array(
			'path' => null,
			'file' => false,
			'connection' => 'default'
		));
		$New = $this->Schema->load();
		return $this->_update($New, $table);
	}

/**
 * @param type $plugin
 * @param type $table
 * @param type $lastTable
 * @return type
 */
	public function _runPluginUpate($plugin, $table = null, $lastTable = null) {
		$testPath = ROOT . DS . SITE_DIR . DS . 'Locale' . DS . 'Plugin' . DS . $plugin . DS . 'Config' . DS . 'Schema' . DS;
		$path = file_exists($testPath . 'schema.php') ? $testPath : null;
		$options = array(
			'name' => $plugin,
			'path' => $path,
			//'file' => false,
			'connection' => 'default',
			'plugin' => $plugin
		);
		$this->Schema = new ZuhaSchema();
		$New = $this->Schema->load($options);

		if (!$New->tables[$table]) {
			return $this->_downgrade($table, $lastTable);
		} else {
			return $this->_update($New, $table, $options);
		}
	}

/**
 * Downgrade table method
 *
 * If a plugin table exists but the plugin isn't loaded remove the table. (for now we back it up)
 *
 * @access public
 * @param string
 * @return array
 * @todo maybe if the table is empty you don't back it up?
 */
	public function _downgrade($table, $lastTable) {
// debug(Debugger::trace());
// debug($table);
// debug($lastTable);
// exit;
		$db = ConnectionManager::getDataSource('default');
		$db->cacheSources = false;
		$tableCheck = $db->query('SHOW TABLES LIKE "' . $table . '";');
		if (!empty($tableCheck)) {
			try {
				$db->execute('DROP TABLE IF EXISTS`zbk_' . $table . '`;');
			} catch (PDOException $e) {
				// do nothing, just tried deleting a table that doesn't exist
				debug($e->getMessage());
				exit;
			}

			if ($db->query('SELECT * FROM `' . $table . '`;')) {
				// backup a table that we're about to delete
				try {
					$db->execute('CREATE TABLE `zbk_' . $table . '` LIKE `' . $table . '`;');
					$db->execute('INSERT INTO `zbk_' . $table . '` SELECT * FROM `' . $table . '`;');
					// don't return anything the table has to be deleted still
					// return array($lastTable => __('AND %s removed', $table));
				} catch (PDOException $e) {
					throw new Exception($table . ': ' . $e->getMessage());
				}
			}

			try {
				// backups were done above if and only if there was data in the table.
				// $db->execute('CREATE TABLE `zbk_' . $table . '` LIKE `' . $table . '`;'); // back it up first
				// $db->execute('INSERT INTO `zbk_' . $table . '` SELECT * FROM `' . $table . '`;');
				$db->query('DROP TABLE `' . $table . '`;');
				// need the last table, because the table just removed will no longer exist in the tables array
				return array($lastTable => __('AND %s removed', $table));
			} catch (PDOException $e) {
				throw new Exception($table . ': ' . $e->getMessage());
			}
		} else {
			// the table doesn't exist so its already downgraded
			return array($table => __('AND %s was already gone', $table));
		}
	}

/**
 * Update method
 *
 * Check if update is needed, if confirmed is true, run the update
 *
 * @access public
 * @param object
 * @param string
 * @param bool
 * @return mixed
 */
	public function _update(&$Schema, $table = null, $options = array()) {
		$db = ConnectionManager::getDataSource($this->Schema->connection);
		$db->cacheSources = false;

		try {
			$Old = $this->Schema->read($options);
// debug($Old);
// exit;
		} catch (Exception $e) {
			if (get_class($e) == 'MissingTableException' && in_array($table, array_keys($Schema->tables))) {
				// missing table create it
				$tableName = explode(' ', $e->getMessage()); // string like Table table_name for model TableName was not found in ...'
// debug($e->getMessage());
// debug($tableName);
// debug($db->createSchema($Schema, $tableName[1]));
// exit;
				$this->_run($db->createSchema($Schema, $tableName[1]), 'create', $Schema);
			} else {
				debug('Hopefully we do not reach this spot.');
				debug($e->getMessage());
				exit;
			}
		}
		$compare = $this->Schema->compare($Old, $Schema);
// debug($table);
// debug($compare);
// debug($Old);
// debug($Schema);
// exit;
		$contents = array();
		if (empty($table)) {
// debug($table);
// debug($compare);
// exit;
			foreach ($compare as $table => $changes) {
				$contents[$table] = $db->alterSchema(array($table => $changes), $table);
			}
		} elseif (isset($compare[$table])) {
// turn on to see what the change is (works good for finding those tables that update every single time)
// debug('old : table -> field -> parameters');
// debug(array($table => array(key($compare[key($compare)]['change']) => $Old['tables'][key($compare)][key($compare[key($compare)]['change'])])));
// debug('new');
// debug($compare);
// exit;
			$contents[$table] = $db->alterSchema(array($table => $compare[$table]), $table);
// debug($contents);
// exit;
		} elseif (!empty($compare[key($compare)]['create'])) {
// debug($compare);
// debug($Schema);
// debug($db->createSchema($Schema, key($compare)));
// exit;
			try {
				$this->_run($db->createSchema($Schema, key($compare)), 'create', $Schema);
			} catch (Exception $e) {
				// we ignore this exception, because we can get to this spot multiple times in a single update
				// debug($e->getMessage());
				// exit;
			}
		}

		if (empty($contents)) {
			return array($table => 'up to date'); // its already up to date
		}

		$out = array();
		$i = 0;
		foreach ($contents as $key => $value) {
			$out[$i]['table'] = $key;
			$out[$i]['queries'] = $value;
			$out[$i]['name'] = $this->Schema->name;
			$out[$i]['plugin'] = $this->Schema->plugin;
			$i = $i + 1;
		}
//		debug($out);//  turn on to see queries as they run

		if (!empty($this->controller->request->data['Upgrade']['all'])) {
			try {
				return $this->_run($contents, 'update', $Schema);
			} catch (Exception $e) {
				debug($e->getMessage());
				debug($contents);
				debug($compare);
				exit;
				throw new Exception('You need to run this update manually.  Probably an unrecognized column type, like enum.', 1);
			}
		}
		return $out;
	}

/**
 * Runs sql from _create() or _update()
 *
 * @param array $contents
 * @param string $event
 * @param ZuhaSchema $Schema
 * @return void
 */
	public function _run($contents, $event, &$Schema) {
		if (empty($contents)) {
			// debug($contents);
			// debug($event);
			// debug($Schema);
			throw new Exception(__('Sql could not be run'));
		}

		Configure::write('debug', 2);
		$db = ConnectionManager::getDataSource($this->Schema->connection);
		if (is_string($contents)) {
			// its a string if we're creating a new table, execute single query
			try {
				$db->execute($contents);
				return array($Schema->name => ' updated table'); // create is run
			} catch (PDOException $e) {
				$error = $e->getMessage();
				throw new Exception($error);
			}
		}
		foreach ($contents as $table => $sql) {
			if (empty($sql)) {
				return array($table => 'up to date');
			} else {
				if (!$Schema->before(array($event => $table))) {
					debug($table);
					exit;
//					break;
//					return false;
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
 * @access public
 * @return array
 */
	public function _tables() {
		$db = ConnectionManager::getDataSource('default');
		foreach ($db->listSources() as $table) {
			if (strpos($table, 'zbk_') === false) {
				$plugin = ZuhaInflector::pluginize($table);
				if (ctype_lower($plugin)) {
					throw new Exception(__('I bet someone added a db table (%s), without noting it in bootstrap::ZuhaInflector::pluginize. Please check.', $table));
				}
				$tables[$table] = $plugin;
			}
		}
		return $tables;
	}

/**
 * Temp settings
 *
 * turns on debug and disables cache, then sets them back to what they were previously
 */
	public function _tempSettings($start = true) {
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
	public function _upgrade() {
		$db = ConnectionManager::getDataSource('default');
		$tables = $db->listSources();
	}

}

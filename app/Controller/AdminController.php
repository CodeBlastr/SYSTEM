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
 * @link          http://zuha.com Zuha™ Project
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
    public function index () {
		if (!empty($this->request->data['Upgrade']['all'])) {
			$this->_runUpdates();
			$this->set('runUpdates', true);
		} else {
			$this->Session->delete('Updates');
		}
		$this->Session->write('Updates.end', end(CakePlugin::loaded()));
	}
	
	
	protected function _runUpdates() {
		$tables = $this->_tables();
		
		// check the session for the last TABLE run (we need an array of all tables) 
		debug($this->Session->read());
		break;
		// $db = ConnectionManager::getDataSource($connection);
		// $db->listSources();
		
		// see if the NEXT TABLE is in a plugin or not
		
		// if NOT a plugin run the core update and write the session using the table name and status
		
		// if it is a plugin run the plugin update and write the session using the table name and status
		
		// find the next TABLE to run, use the TABLE's plugin to get the CakeSchema

		
		// if last TABLE run equals the end then quit and set a session Updates.complete = true and quit
	}
	
	protected function _tables() {
		$db = ConnectionManager::getDataSource('default');
		foreach ($db->listSources() as $table) {
			$tables[$table] = ZuhaInflector::pluginize($table);
		}
		
		debug($tables);
		break;
	}
	
	
	
	
	
/**
 * Check for updates
 *
 * Check all schema.php files against the current database to make sure we're fully up to date.
 * 
 * @access protected
 * @param void
 * @return void
 */
	protected function _checkUpdates() {
		$last = $this->Session->read('Updates.last') ? $this->Session->read('Updates.last') : array();
		$lastTable = key(array_slice($this->Session->read('Updates.last'), -1));
		
		$debug = Configure::read('debug');
		Configure::write('debug', 2);
		$cacheDisable = Configure::read('Cache.disable');
		Configure::write('Cache.disable', true);
		
		$this->Schema = new CakeSchema(array('path' => null, 'file' => false, 'connection' => 'default'));
		$New = $this->Schema->load();
				
		$lastPlugin = array_search(strtolower(ZuhaInflector::pluginize($lastTable)), array_map('strtolower', CakePlugin::loaded()));
		
		if ($lastPlugin === false && $upgrade = $this->_update($New)) {
			$this->Session->write('Updates.last', array_merge($last, $upgrade)); // core updates
		} else {
			$plugins = CakePlugin::loaded();
			$next = current(array_slice($plugins, array_search(ZuhaInflector::pluginize($lastTable), $plugins) + 1 ));			
			
			
			$this->Schema = new CakeSchema(array('name' => $next, 'path' => null, 'file' => false, 'connection' => 'default', 'plugin' => $next));				
			$New = $this->Schema->load();
			
			if ($upgrade = $this->_update($New)) {
				$this->Session->write('Updates.last', array_merge($last, $upgrade)); // plugin updates
			} else {
				$this->Session->write('Updates.last', array_merge($last, array(strtolower($next) => 'up to date'))); // 
			}
		}
		
		Configure::write('Cache.disable', $cacheDisable);	
		Configure::write('debug', $debug);	
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
			return false; // its already up to date we don't need to update
		}
		
		$i = 0;
		foreach($contents as $key => $value) {
			$out[$i]['table'] = $key;
			$out[$i]['queries'] = $value;
			$out[$i]['name'] = $this->Schema->name;
			$out[$i]['plugin'] = $this->Schema->plugin;
			$i = $i + 1;
		}
		debug($out); // turn on to see queries after they run
		
		if (!empty($this->request->data['Upgrade']['all'])) {
			try {
				return $this->_run($contents, 'update', $Schema);
			} catch (Exception $e) {
				debug($e);
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
	
}
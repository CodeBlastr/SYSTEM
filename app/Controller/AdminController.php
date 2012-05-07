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
		$this->_checkUpdates();
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
		$debug = Configure::read('debug');
		Configure::write('debug', 2);
		$cacheDisable = Configure::read('Cache.disable');
		Configure::write('Cache.disable', true);
		
		$this->Schema = new CakeSchema(array('path' => null, 'file' => false, 'connection' => 'default'));
		$New = $this->Schema->load();
		
		if ($upgradeDb = $this->_update($New)) { // core updates
			if ($upgradeDb === true) {
    			$this->Session->setFlash(__('Update run. <a href="/admin">Check for more.</a>'));
			} else {
				$this->set(compact('upgradeDb'));
			}
		} else {
			foreach (CakePlugin::loaded() as $plugin) {
				$this->Schema = new CakeSchema(array('name' => $plugin, 'path' => null, 'file' => false, 'connection' => 'default', 'plugin' => $plugin));
			
				$New = $this->Schema->load();
			
				if ($upgradeDb = $this->_update($New)) { // plugin updates
					if ($upgradeDb === true) {
	    				$this->Session->setFlash(__('Update run. <a href="/admin">Check for more.</a>'));
						break; // so that we do one update at a time (really slow to check for updates)
					} else {
						$this->set(compact('upgradeDb'));
						break; // so that we do one update at a time (really slow to check for updates)
					}
				}
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
			$out[$i]['plugin'] = $this->Schema->plugin;
			$i = $i + 1;
		}
		
		if (!empty($this->request->data['Upgrade']['confirmed'])) {
			try {
				$this->_run($contents, 'update', $Schema);
				return true;
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
				$out = __('%s is up to date.', $table);
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
					return true; // update is run
				}
			}
		}
	}
	
}
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
		if (!empty($this->request->data['Admin']['icon'])) {
			$this->_saveFavicon();
		}
		if (!empty($this->request->data['Admin']['export'])) {
			$this->_exportSite();
		}
		if (!empty($this->request->data['Upgrade']['all'])) {
			$this->_runUpdates();
			$this->set('runUpdates', true);
		}
		if (!empty($this->request->data['Update']['index'])) {
			$this->view = 'index_upgrade';
		} 
		if (!empty($this->request->data['Alias']['update'])) {
			App::uses('Alias', 'Model');
			$Alias = new Alias;
			$this->set('syncd', $Alias->sync());
			$this->view = 'index_upgrade';
		}
		$complete = $this->Session->read('Updates.complete');
		if (!empty($complete)) {
			$this->Session->delete('Updates'); 
			$this->Session->setFlash(__('Update check complete!!!'));
		}
		$this->set('page_title_for_layout', 'Admin Dashboard');
		$this->layout = 'default';
		
		// this is here so we can show "Add Post" links foreach Blog on the dashboard
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
		// debug($lastTable);
		// debug($nextTable);
		// debug($nextPlugin); // if false, means its not a plugin
		//debug(CakePlugin::loaded());
		// debug($endTable);
		// debug($allTables);
		// debug($this->Session->read());
		// break;
		
		if (!empty($nextPlugin) && !in_array($nextPlugin, CakePlugin::loaded())) { 
			// plugin is not loaded so downgrade
			$last = !empty($lastTableWithPlugin) ? array_merge($lastTableWithPlugin, $this->_downgrade($nextTable, $lastTable)) : $this->_downgrade($nextTable, $lastTable);
			$this->Session->write('Updates.last', $last);
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
				$db->execute('CREATE TABLE `zbk_' . $table . '` LIKE `' . $table . '`;'); // back it up first
				$db->execute('INSERT INTO `zbk_' . $table . '` SELECT * FROM `' . $table . '`;');
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
		
		try {
			$Old = $this->Schema->read($options);
		} catch (Exception $e) {
			if (get_class($e) == 'MissingTableException' && in_array($table, array_keys($Schema->tables))) {
				// missing table create it
				$tableName = explode(' ', $e->getMessage()); // string like Table table_name for model TableName was not found in ...'
				$this->_run($db->createSchema($Schema, $tableName[1]), 'create', $Schema);
			} else {
				debug('Hopefully we do not reach this spot.');
				debug($e->getMessage());
				break;
			}
		}
		$compare = $this->Schema->compare($Old, $Schema);
		
		$contents = array();

		if (empty($table)) {
			foreach ($compare as $table => $changes) {
				$contents[$table] = $db->alterSchema(array($table => $changes), $table);
			}
		} else if (isset($compare[$table])) {
			// turn on to see what the change is
			// debug('old : table -> field -> parameters');
			// debug(array($table => array(key($compare[key($compare)]['change']) => $Old['tables'][key($compare)][key($compare[key($compare)]['change'])])));
			// debug('new');
			// debug($compare);
			// break;
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
				debug($contents);
				debug($compare);
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
		
		// left as an example, but we don't use that setting anymore, so not much use
		// if (defined('__SYSTEM_ZUHA_DB_VERSION') && __SYSTEM_ZUHA_DB_VERSION < 0.0192) {
			// // eliminate used table duplicates so that the index can be added
			// if (array_search('user_followers', $tables)) {
				// $totals = $db->query('SELECT `id`, COUNT(*) AS total FROM `user_followers` GROUP BY `id` ORDER BY `total` DESC;');
				// foreach ($totals as $total) {
					// if ($total[0]['total'] > 1) {
						// $limit = $total[0]['total'] - 1;
						// $db->query('DELETE FROM `user_followers` WHERE `user_followers`.`id` = \''.$total['user_followers']['id'].'\'  LIMIT '.$limit.';');
					// }
				// }
			// }
		// }	
	}
	
	protected function _saveFavicon() {
		$upload = ROOT . DS . SITE_DIR . DS . 'Locale' . DS . 'View' . DS . WEBROOT_DIR . DS . 'favicon.ico';
		if(move_uploaded_file($this->request->data['Admin']['icon']['tmp_name'], $upload)){
			$this->Session->setFlash('Favicon Updated. NOTE ( You may need to clear browser history and refresh to see it. )');
			!empty($this->request->data['Override']) ? $this->redirect('/admin') : null; // not needed, but we get here through /install/build so this is a quick and dirty fix
		}
	}
	
	protected function _exportSite() {
		$tmpdir = TMP . 'backup';
		$plugins = CakePlugin::loaded();
		$includes = array();
		foreach ($plugins as $plugin) {
			$includes['app']['Plugin'][$plugin] = true;
		}
		$includes['app']['*'] = true;
		$includes['*'] = true;
		$includes['tmp'] = false;
		$includes['sites'] = false;
		$includes['vendors'] = false;
		$includes['sites.default'] = false;
		
		$filename = strtolower(str_replace(' ', '_', __SYSTEM_SITE_NAME));
		
		
		try {
			//Create backup directory
			mkdir($tmpdir, 0777);
			chmod($tmpdir, 0777);
			// copy root folder without sites and plugins
			$this->copyr(ROOT, $tmpdir, $includes);
			//Copy the site seperate
			$sourcefolder = basename(ROOT);
			$this->copyr(ROOT . DS . SITE_DIR, $tmpdir . DS . $sourcefolder . DS . 'sites', array('*' => true, 'Config' => array('defaults.ini' => true, 'database.php' => false, 'core.php' => true, 'settings.ini' => true), 'tmp' => false));
			//dump the database
			$db = ConnectionManager::getDataSource('default');
			$dbname = $db->config['database'];
			$dbuser = $db->config['login'];
			$dbpass = $db->config['password'];
			exec('mysql dump -u '.$dbuser.' -p ['.$dbpass.'] ['.$dbname.'] > '.$tmpdir . DS . $sourcefolder . DS . $filename.'.sql');
		}catch (Exception $e) {
			$this->Session->setFlash('Error: '.$e->getMessage());
		}
		
		exec('cd '.$tmpdir.DS.$sourcefolder.';zip -r '.$tmpdir.DS.$filename.'.zip *');
		
		try {
			$this->returnFile($tmpdir.DS.$filename.'.zip', $filename.'.zip', 'zip');
		}catch (Exception $e) {
			$this->Session->setFlash('Error: '.$e->getMessage());
		}
		
		//remove the backup folder
		exec('rm -R '.$tmpdir);
		
	}
	
	static protected function copyr($source, $dest, $includes = false)
	{
		if(is_array($includes)) {
			$allfiles = isset($includes['*']) ? $includes['*'] : false;
		}else {
			$allfiles = true;
		}
		// recursive function to copy
		// all subdirectories and contents:
		if(is_dir($source)) {
			$dir_handle=opendir($source);
			$sourcefolder = basename($source);
			mkdir($dest.DS.$sourcefolder, 0777, true);
			while($file=readdir($dir_handle)){
				if($file != "." && $file != ".."){
					$check = false;
					if(isset($includes[$file])) {
						$check = is_array($includes[$file]) ? true : $includes[$file];
					}else {
						$check = $allfiles;
					}
					
					if($check) {
						if(is_dir($source.DS.$file)){
							if($file[0] != '.') {
								$inc = false;
								if(is_array($includes[$file])) {
									$inc = $includes[$file];
								}elseif(is_bool($includes[$file])) {
									$inc = $includes[$file];
								}
								self::copyr($source.DS.$file, $dest.DS.$sourcefolder, $inc);
							}
						} else {
							if($file[0] != '.' || $file == '.htaccess') {
								if(!copy($source.DS.$file, $dest.DS.$sourcefolder.DS.$file)) {
									throw new Exception('Error Copying File');
								}
							}
						}
					}
				}
			}
			closedir($dir_handle);
		} else {
			// can also handle simple copy commands
			copy($source, $dest);
		}
	}
	
	private function returnFile($file, $name, $mime_type = '') {
		/*
		 * This function takes a path to a file to output ($file), the filename that the browser will see ($name) and the MIME type of the file ($mime_type, optional). If you want to do something on download abort/finish, register_shutdown_function('function_name');
		 */
		 
		 $i = 0;
		 while (!file_exists($file)) {
		 	++$i;
			 if ($i > 10000000) {
			 	throw new Exception('I can\'t find the file.', 1);
			 }
		 }

		if (!is_readable($file)) {
			throw new Exception('file cannot found or is inaccessible!', 1);
		}

		$size = filesize($file);
		$name = rawurldecode($name);

		/* Figure out the MIME type (if not specified) */
		$known_mime_types = array(
				"pdf" => "application/pdf",
				"txt" => "text/plain",
				"html" => "text/html",
				"htm" => "text/html",
				"exe" => "application/octet-stream",
				"zip" => "application/zip",
				"doc" => "application/msword",
				"xls" => "application/vnd.ms-excel",
				"ppt" => "application/vnd.ms-powerpoint",
				"gif" => "image/gif",
				"png" => "image/png",
				"jpeg" => "image/jpg",
				"jpg" => "image/jpg",
				"php" => "text/plain"
		);

		if ($mime_type == '') {
			$file_extension = strtolower(substr(strrchr($file, "."), 1));

			if (array_key_exists($file_extension, $known_mime_types)) {
				$mime_type = $known_mime_types [$file_extension];
			} else {
				$mime_type = "application/force-download";
			}
		}

		// @ob_end_clean(); //turn off output buffering to decrease cpu usage
		// required for IE, otherwise Content-Disposition may be ignored
		if (ini_get('zlib.output_compression')) {
			ini_set('zlib.output_compression', 'Off');
		}

		header('Content-Type: ' . $mime_type);
		header('Content-Disposition: attachment; filename="' . $name . '"');
		header('Content-Transfer-Encoding: binary');
		header('Accept-Ranges: bytes');

		/* The three lines below basically make the download non-cacheable */
		header('Cache-control: private');
		header('Pragma: private');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');

		// multipart-download and download resuming support
		if (isset($_SERVER ['HTTP_RANGE'])) {
			list ( $a, $range ) = explode('=', $_SERVER ['HTTP_RANGE'], 2);
			list ( $range ) = explode(',', $range, 2);
			list ( $range, $range_end ) = explode('-', $range);

			$range = intval($range);

			$range_end = (!$range_end) ? $size - 1 : intval($range_end);
			$new_length = $range_end - $range + 1;

			header('HTTP/1.1 206 Partial Content');
			header('Content-Length: ' . $new_length);
			header('Content-Range: bytes ' . ($range - $range_end / $size));
		} else {
			$new_length = $size;

			header('Content-Length: ' . $size);
		}

		/* output the file itself */
		$chunksize = 1 * (2048 * 2048); // you may want to change this
		$bytes_send = 0;

		if ($file = fopen($file, 'r')) {
			if (isset($_SERVER ['HTTP_RANGE'])) {
				fseek($file, $range);
			}

			while ( !feof($file) && (!connection_aborted()) && ($bytes_send < $new_length) ) {
				$buffer = fread($file, $chunksize);

				print($buffer);
				flush();

				$bytes_send += strlen($buffer);
			}

			fclose($file);
		} else {
			die('Error - can not open file.');
		}
	}
	
}
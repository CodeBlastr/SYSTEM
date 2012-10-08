<?php
App::uses('CakeSchema', 'Model');

class InstallController extends AppController {

	public $name = 'Install';
    public $uses = array();
	public $params;
	public $progress;
	public $options;
	public $config;
	public $allowedActions = array('index', 'site', 'login', 'plugin');

/**
 * Schema class being used.
 *
 * @var CakeSchema
 */
	public $Schema;

	public function __construct($request = null, $response = null) {

		parent::__construct($request, $response);

		$this->_handleSitesDirectory();
		if ($request->controller == 'install' || $request->action == 'site') {
			Configure::write('Session', array(
				'defaults' => 'php',
				'cookie' => 'PHPSESSID'
			));
		}

		$name = $path = $connection = $plugin = null;
		if (!empty($this->params['name'])) {
			$name = $this->params['name'];
		} elseif (!empty($this->args[0])) {
			$name = $this->params['name'] = $this->args[0];
		}

		if (strpos($name, '.')) {
			list($this->params['plugin'], $splitName) = pluginSplit($name);
			$name = $this->params['name'] = $splitName;
		}

		if ($name) {
			$this->params['file'] = Inflector::underscore($name);
		}

		if (empty($this->params['file'])) {
			$this->params['file'] = 'schema.php';
		}
		if (strpos($this->params['file'], '.php') === false) {
			$this->params['file'] .= '.php';
		}
		$file = $this->params['file'];

		if (!empty($this->params['path'])) {
			$path = $this->params['path'];
		}

		if (!empty($this->params['connection'])) {
			$connection = $this->params['connection'];
		}
		if (!empty($this->params['plugin'])) {
			$plugin = $this->params['plugin'];
			if (empty($name)) {
				$name = $plugin;
			}
		}
		$this->Schema = new CakeSchema(compact('name', 'path', 'file', 'connection', 'plugin'));
	}


	protected function _out($out) {
		debug($out);
	}

/**
 * write the class vars that are used through out the functions in this class
 */
	protected function _handleInputVars($data) {
		$this->options['siteName'] = $this->request->data['Install']['site_name'];
		if (strpos($this->request->data['Install']['site_domain'], ',')) :
			# comma separated domain handler
			$this->siteDomains = array_map('trim', explode(',', $this->request->data['Install']['site_domain']));
			$this->options['siteDomain'] = $this->siteDomains[0];
		else :
			$this->options['siteDomain'] = $this->request->data['Install']['site_domain'] == 'mydomain.com' ? '' : $this->request->data['Install']['site_domain'];
		endif;
		$this->config['datasource'] = 'Database/Mysql';
		$this->config['host'] = $data['Database']['host'];
		$this->config['login'] = $data['Database']['username'];
		$this->config['password'] = $data['Database']['password'];
		$this->config['database'] = $data['Database']['name'];
		$this->newDir = ROOT.DS.'sites'.DS.$this->options['siteDomain'];
		if (is_dir($this->newDir)) :
			$this->Session->setFlash(__('That domain already exists, please try again.'));
			$this->redirect($this->referer());
		endif;
	}

	public function index() {
		$this->_handleSecurity();
		$currentlyLoadedPlugins = CakePlugin::loaded();

		CakePlugin::loadAll();
		$unloadedPlugins = array_diff(CakePlugin::loaded(), $currentlyLoadedPlugins);

		foreach ($unloadedPlugins as $unloadedPlugin) {
			# unload the plugins just loaded
			CakePlugin::unload($unloadedPlugin);
		}

		if (!empty($unloadedPlugins)) {
			$this->set(compact('unloadedPlugins'));
		} else {
			$this->redirect(array('action' => 'site'));
		}
	}

/**
 * Install a plugin to the current site.
 */
	public function plugin($plugin = null) {
		$this->_handleSecurity();
		if (!empty($plugin) && defined('__SYSTEM_LOAD_PLUGINS') ) {
			CakePlugin::load($plugin);
			if ($this->_installPluginSchema($plugin, $plugin)) {
				$plugins = unserialize(__SYSTEM_LOAD_PLUGINS);
				$sqlData = '';
				foreach ($plugins['plugins'] as $sql) {
					$sqlData .= 'plugins[] = ' . $sql . PHP_EOL;
				}
				$sqlData = $sqlData . "plugins[] = {$plugin}";
				# "UPDATE `settings` SET `value` = 'plugins[] = Users\r\nplugins[] = Webpages\r\nplugins[] = Contacts\r\nplugins[] = Galleries\r\nplugins[] = Privileges' WHERE `name` = 'LOAD_PLUGINS';";
				App::uses('Setting', 'Model');
				$Setting = new Setting;
				$data['Setting']['type'] = 'System';
				$data['Setting']['name'] = 'LOAD_PLUGINS';
				$data['Setting']['value'] = $sqlData;
				if ($Setting->add($data)) {
					$this->Session->setFlash(__('Plugin successfully installed.'));
					$this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash(__('Settings update failed.'));
					$this->redirect(array('action' => 'index'));
				}
			} else {
				$this->Session->setFlash(__('Plugin install failed.'));
				$this->redirect(array('action' => 'index'));
			}
		} else {
			$this->Session->setFlash(__('Current plugin setup not valid.'));
			$this->redirect(array('action' => 'index'));
		}
	}


/**
 * Install a new site
 *
 * @todo		  We need some additional security on this.
 */
	public function site() {
		$this->_handleSecurity();
		if (!empty($this->request->data)) {
			# move everything here down to its own function
			$this->_handleInputVars($this->request->data);

			try {
				$db = ConnectionManager::create('default', $this->config);
				try {
					# test the table name
					$sql = ' SHOW TABLES IN ' . $this->config['database'];
					$db->execute($sql);
					# run the core table queries
					$this->_create($db);
					if ($this->lastTableName == $this->progress) {
						# run the required plugins
						if ($this->_installPluginSchema('Users', 'Users')) :
							$users = true;
						endif;
						if ($this->_installPluginSchema('Webpages', 'Webpages')) :
							$webpages = true;
						endif;
						if ($this->_installPluginSchema('Contacts', 'Contacts')) :
							$contacts = true;
						endif;
						if ($this->_installPluginSchema('Galleries', 'Galleries')) :
							$galleries = true;
						endif;
						if ($users && $webpages && $contacts && $galleries) {
							# run the required data
							try {
								$this->_installCoreData($db);
							} catch (Exception $e) {
								throw new Exception($e->getMessage());
							}
							
							try {
								$this->_installCoreFiles();
								$this->redirect('http://'.$this->options['siteDomain'].'/install/login');
							} catch (Exception $e) {
								throw new Exception(__('File copy failed. %s %s', $install, $e->getMessage()));
							}
						} else {
							throw new Exception(__("Error :
								Users: {$users},
								Webpages: {$webpages},
								Contacts: {$contacts},
								Galleries: {$galleries}"));
						}
					}
				} catch (PDOException $e) {
					$error = $e->getMessage();
					$db->disconnect();
					$this->Session->setFlash(__('Database Error : ' . $error));
					$this->redirect($this->referer());
				}
			} catch (Exception $e) {
				$this->Session->setFlash(__('Database Connection Failed. ' . $e->getMessage()));
				$this->redirect($this->referer());
			}
		} // end request data check

		$this->layout = false;
	}

/**
 * Used to verify an install, update the username and password, and then write the settings.ini files.
 */
	public function login() {
		// write the ini data for the new site
		App::uses('Setting', 'Model');
		$Setting = new Setting;
		if ($Setting->writeSettingsIniData()) {

			// get the user from the install data
			App::uses('User', 'Users.Model');
			$User = new User;
			$user = $User->find('first', array(
				'conditions' => array(
					'User.username' => 'admin',
					'User.last_login' => null,
					),
				));

			if(!empty($user)) {
				$this->set(compact('user'));
			} else {
				$this->Session->setFlash(__('Install completed.'));
				// this was changed from referer() because after an install you would be redirected here
				// thanks to Auth redirect having /install/login as the referring url after login for redirect.
				$this->redirect(array('plugin' => 'users', 'controller' => 'users', 'action' => 'my'));
			}


			if (!empty($this->request->data)) {
				//$this->request->data['User']['last_login'] = date('Y-m-d h:i:s');// commented by Akhileshs-Clarion on 8th Oct 2012
				$this->request->data['User']['last_login'] = '';
				if ($User->add($this->request->data)) {
					$this->Session->write('Auth.redirect', null);
					$this->Session->setFlash(__('Install completed! Please test the admin login you just created.'));
					$this->redirect(array('plugin' => 'users', 'controller' => 'users', 'action' => 'login'));
				} else {
					$this->Session->setFlash(__('User update failure.'));
					$this->redirect($this->referer());
				}
			}
		} else {
			$this->Session->setFlash(__('Required settings, update failed.'));
			$this->redirect($this->referer());
		} // write settings ini

		$this->layout = false;
	}


/**
 * Copies example.com, creates the database.php, and core.php files.
 *
 * @todo 		Probably should change this to catch throw syntax because there are a lot of errors with no feedback.
 */
	protected function _installCoreFiles() {
		if (!empty($this->options['siteDomain']) && !empty($this->config)) :
			# copy example.com
			$templateDir = ROOT.DS.'sites'.DS.'example.com';

			if ($this->_copy_directory($templateDir, $this->newDir)) :
				# create database.php
				$fileName = $this->newDir.DS.'Config'.DS.'database.php';
				$contents = "<?php".PHP_EOL.PHP_EOL."class DATABASE_CONFIG {".PHP_EOL.PHP_EOL."\tpublic \$default = array(".PHP_EOL."\t\t'datasource' => 'Database/Mysql',".PHP_EOL."\t\t'persistent' => false,".PHP_EOL."\t\t'host' => '".$this->config['host']."',".PHP_EOL."\t\t'login' => '".$this->config['login']."',".PHP_EOL."\t\t'password' => '".$this->config['password']."',".PHP_EOL."\t\t'database' => '".$this->config['database']."',".PHP_EOL."\t\t'prefix' => '',".PHP_EOL."\t\t//'encoding' => 'utf8',".PHP_EOL."\t);".PHP_EOL."}";
				if ($this->_createFile($fileName, $contents)) :
					# update sites/bootstrap.php
					if ($this->_updateBootstrapPhp()) :
						# run settings
						return true;
					else :
						break; return false;
					endif;
				else :
					break; return false;
				endif;
			else :
				break; return false;
			endif;
		else:
			break; return false;
		endif;
	}


	protected function _updateBootstrapPhp() {
		$filename = ROOT.DS.'sites'.DS.'bootstrap.php';
		$filesize = filesize($filename);
		$file = fopen($filename, 'r');
		$filecontents = fread($file, $filesize);
		fclose($file);

		if (!empty($this->siteDomains)) :
			$replace = '';
			foreach($this->siteDomains as $site) :
				$replace .= "\$domains['".$site."'] = '".$this->options['siteDomain']."';".PHP_EOL;
			endforeach;
		else :
			$replace = "\$domains['".$this->options['siteDomain']."'] = '".$this->options['siteDomain']."';".PHP_EOL;
		endif;

		# make a back up first
		if (copy($filename, ROOT.DS.'sites'.DS.'bootstrap.'.date('Ymdhis').'.php')) :
			$contents = str_replace('/** end **/', $replace.PHP_EOL.'/** end **/', $filecontents);
			if(file_put_contents($filename, $contents)) :
				return true;
			endif;
		endif;
		return false;
	}


	protected function _createFile($fileName = null, $contents = null) {
		$fh = fopen($fileName, 'w') or die("can't open file");
		if (fwrite($fh, $contents)) :
			fclose($fh);
			return true;
		endif;

		return false;

		/*
		$this->newDir
			$this->options['siteName'] = $this->request->data['Install']['site_name'];
			$this->options['siteDomain'] = $this->request->data['Install']['site_domain'] == 'mydomain.com' ? '' : $this->request->data['Install']['site_domain'];
			$this->config['host'] = $dataSource['host'];
			$this->config['login'] = $dataSource['username'];
			$this->config['password'] = $dataSource['password'];
			$this->config['database'] = $dataSource['name'];
			*/
	}



	protected function _installPluginSchema($name = null, $plugin = null) {
		if (!empty($name) && !empty($plugin)) :
			$this->params['name'] = $name;
			$this->params['plugin'] = $plugin;
			$blank = '';
			$this->_create($blank);
			if ($this->lastTableName == $this->progress) :
				return true;
			else :
				return false;
			endif;
		else :
			return false;
		endif;
	}


/**
 * Prepares the Schema objects for database operations.
 *
 * @return void
 */
	protected function _loadSchema() {
		$name = $plugin = null;
		if (!empty($this->params['name'])) {
			$name = $this->params['name'];
		}
		if (!empty($this->params['plugin'])) {
			$plugin = $this->params['plugin'];
		}

		if (!empty($this->params['dry'])) {
			$this->_dry = true;
			$this->_out(__d('cake_console', 'Performing a dry run.'));
		}

		$options = array('name' => $name, 'plugin' => $plugin);
		if (!empty($this->params['snapshot'])) {
			$fileName = rtrim($this->Schema->file, '.php');
			$options['file'] = $fileName . '_' . $this->params['snapshot'] . '.php';
		}
		$Schema = $this->Schema->load($options);	
		
		if (!$Schema) {
			$this->Session->setFlash(__('No schema file found for this plugin.'));
			$this->redirect($this->referer());
		}
		$table = null;
		if (isset($this->args[1])) {
			$table = $this->args[1];
		}
		return array(&$Schema, $table);
	}

/**
 * Create database from Schema object
 * Should be called via the run method
 *
 * @param CakeSchema $Schema
 * @param string $table
 * @return void
 */
	protected function _create($Schema, $table = null) {
		list($Schema, $table) = $this->_loadSchema();
		$db = ConnectionManager::getDataSource($this->Schema->connection);

		$drop = $create = array();

		if (!$table) {
			foreach ($Schema->tables as $table => $fields) {
				$drop[$table] = $db->dropSchema($Schema, $table);
				$create[$table] = $db->createSchema($Schema, $table);
			}
		} elseif (isset($Schema->tables[$table])) {
			$drop[$table] = $db->dropSchema($Schema, $table);
			$create[$table] = $db->createSchema($Schema, $table);
		}
		$end = $create; end($end);
		$this->lastTableName = key($end); // get the last key in the array
		$this->_run($drop, 'drop', $Schema);
		$this->_run($create, 'create', $Schema);

		/* These are some checks that aren't needed for the initial install
		if (empty($drop) || empty($create)) {
			$this->_out(__d('cake_console', 'Schema is up to date.'));
			$this->_stop();
		}

		$this->_out("\n" . __d('cake_console', 'The following table(s) will be dropped.'));
		$this->_out(array_keys($drop));

		if ('y' == $this->in(__d('cake_console', 'Are you sure you want to drop the table(s)?'), array('y', 'n'), 'n')) {
			$this->_out(__d('cake_console', 'Dropping table(s).'));
			$this->_run($drop, 'drop', $Schema);
		}

		$this->_out("\n" . __d('cake_console', 'The following table(s) will be created.'));
		$this->_out(array_keys($create));

		if ('y' == $this->in(__d('cake_console', 'Are you sure you want to create the table(s)?'), array('y', 'n'), 'y')) {
			$this->_out(__d('cake_console', 'Creating table(s).'));
			$this->_run($create, 'create', $Schema);
		}
		$this->_out(__d('cake_console', 'End create.'));*/
	}

/**
 * Update database with Schema object
 * Should be called via the run method
 *
 * @param CakeSchema $Schema
 * @param string $table
 * @return void
 */
	protected function _update(&$Schema, $table = null) {
		list($Schema, $table) = $this->_loadSchema();
		$db = ConnectionManager::getDataSource($this->Schema->connection);

		$this->_out(__d('cake_console', 'Comparing Database to Schema...'));
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
		} elseif (isset($compare[$table])) {
			$contents[$table] = $db->alterSchema(array($table => $compare[$table]), $table);
		}

		if (empty($contents)) {
			$this->_out(__d('cake_console', 'Schema is up to date.'));
			$this->_stop();
		}

		$this->_out("\n" . __d('cake_console', 'The following statements will run.'));
		$this->_out(array_map('trim', $contents));
		if ('y' == $this->in(__d('cake_console', 'Are you sure you want to alter the tables?'), array('y', 'n'), 'n')) {
			$this->_out();
			$this->_out(__d('cake_console', 'Updating Database...'));
			$this->_run($contents, 'update', $Schema);
		}

		$this->_out(__d('cake_console', 'End update.'));
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
			$this->err(__d('cake_console', 'Sql could not be run'));
			return;
		}
		Configure::write('debug', 2);
		$db = ConnectionManager::getDataSource($this->Schema->connection);

		foreach ($contents as $table => $sql) {
			if (empty($sql)) {
				$this->_out(__d('cake_console', '%s is up to date.', $table));
			} else {
				if ($this->_dry === true) {
					$this->_out(__d('cake_console', 'Dry run for %s :', $table));
					$this->_out($sql);
				} else {
					if (!$Schema->before(array($event => $table))) {
						return false;
					}
					$error = null;
					try {
						$db->execute($sql);
					} catch (PDOException $e) {
						$error = $table . ': '  . $e->getMessage();
					}

					$Schema->after(array($event => $table, 'errors' => $error));

					if (!empty($error)) {
						$this->err($error);
					} else {
						$this->progress = $table;
						#$this->_out(__d('cake_console', '%s updated.', $table));
					}
				}
			}
		}
	}

/**
 * Install the data necessary to have a working zuha site.
 * 
 * @todo Roll back the database (delete the tables) if it fails
 */
	protected function _installCoreData(&$db) {
		# run each data sql insert
		foreach ($this->_getInstallSqlData() as $sql) {
			try {
				$db->query($sql);
			} catch (PDOException $e) {
				$error = $e->getMessage();
				throw new Exception($error);
			}
		}
		return true;
	}


/**
 * The least amount of sql needed to successfully install zuha.
 */
	private function _getInstallSqlData() {

		$options['siteName'] = !empty($this->options['siteName']) ? $this->options['siteName'] : 'My Site';

		$dataStrings[] = "INSERT INTO `aliases` (`id`, `plugin`, `controller`, `action`, `value`, `name`, `created`, `modified`) VALUES
(1, 'webpages', 'webpages', 'view', 1, 'home', '2011-12-15 22:46:29', '2011-12-15 22:47:07');";

		$dataStrings[] = "INSERT INTO `aros` (`id`, `parent_id`, `model`, `foreign_key`, `alias`, `lft`, `rght`) VALUES (1, NULL, 'UserRole', 1, NULL, 1, 4), (2, NULL, 'UserRole', 2, NULL, 5, 6), (3, NULL, 'UserRole', 3, NULL, 7, 8), (6, 1, 'User', 1, NULL, 2, 3), (5, NULL, 'UserRole', 5, NULL, 9, 10);";

		$dataStrings[] = "INSERT INTO `contacts` (`id`, `name`, `user_id`, `is_company`, `created`, `modified`) VALUES
('1', 'Zuha Administrator', 1, 0, '".date('Y-m-d h:i:s')."', '".date('Y-m-d h:i:s')."');";

		$dataStrings[] = "INSERT INTO `settings` (`id`, `type`, `name`, `value`) VALUES (1, 'System', 'ZUHA_DB_VERSION', '0.0176'), (2, 'System', 'GUESTS_USER_ROLE_ID', '5'), (3, 'System', 'LOAD_PLUGINS', 'plugins[] = Users\r\nplugins[] = Webpages\r\nplugins[] = Contacts\r\nplugins[] = Galleries\r\nplugins[] = Privileges'), (4, 'System', 'SITE_NAME', '".$options['siteName']."');";

		$dataStrings[] = "INSERT INTO `users` (`id`, `full_name`, `first_name`, `last_name`, `username`, `password`, `email`, `view_prefix`, `user_role_id`, `created`, `modified`) VALUES
('1', 'Zuha Administrator', 'Zuha', 'Administrator', 'admin', '3eb13b1a6738103665003dea496460a1069ac78a', 'admin@example.com', 'admin', 1, '".date('Y-m-d h:i:s')."', '".date('Y-m-d h:i:s')."');";

		$dataStrings[] = "INSERT INTO `user_roles` (`id`, `parent_id`, `name`, `lft`, `rght`, `view_prefix`, `is_system`, `created`, `modified`) VALUES (1, NULL, 'admin', 1, 2, 'admin', 0, '0000-00-00 00:00:00', '2011-12-15 22:55:24'), (2, NULL, 'managers', 3, 4, '', 0, '0000-00-00 00:00:00', '2011-12-15 22:55:41'), (3, NULL, 'users', 5, 6, '', 0, '0000-00-00 00:00:00', '2011-12-15 22:55:50'), (5, NULL, 'guests', 7, 8, '', 0, '0000-00-00 00:00:00', '2011-12-15 22:56:05');";

		$dataStrings[] = "INSERT INTO `webpages` (`id`, `name`, `content`) VALUES
(1, 'Homepage', 'Congratulations!&nbsp;&nbsp; Welcome to the first page of your new install.&nbsp;&nbsp;');";

		return $dataStrings;

	}

/**
 * Creates the sites folder if it doesn't exist as a copy of sites.default
 */
	protected function _handleSitesDirectory() {
		if (@!is_writable(ROOT.DS.'app'.DS.'tmp'.DS.'logs')) {
			$errorOne = '<ul><li>Please give write permissions to the <strong>'.ROOT.DS.'app'.DS.'tmp'.DS.'logs</strong> directory. </li></ul>';
			$die = true;
		}
		if (@!is_writable(ROOT.DS.'sites')) {
			$errorTwo = '<ul><li>Please give write permissions to the <strong>'.ROOT.DS.'sites</strong> directory. </li></ul>';
			$die = true;
		}
		if ($die === true) {
			echo '<h1>Problem with server compatibility.</h1>';
			echo $errorOne ? $errorOne : null;
			echo $errorTwo ? $errorTwo : null;
			die;
		}
		
		if (file_exists(ROOT.DS.'sites.default') && !file_exists(ROOT.DS.'sites/example.com')) {
			if($this->_copy_directory(ROOT.DS.'sites.default', ROOT.DS.'sites')) {
			} else {
				echo 'Please update write permissions for the "sites" directory.';
				die;
			}
		}
	}


/**
 * recurisive directory copying
 *
 * @todo 		Needs an error to return false
 */
	protected function _copy_directory($src, $dst) {
	    $dir = opendir($src);
	    @mkdir($dst);
	    while(false !== ( $file = readdir($dir)) ) {
	        if (( $file != '.' ) && ( $file != '..' )) {
	            if ( is_dir($src . '/' . $file) ) {
	                $this->_copy_directory($src . '/' . $file,$dst . '/' . $file);
    	        } else {
            	    if (copy($src . '/' . $file,$dst . '/' . $file)) {
						
					} else {
						echo 'sites copy problem';
						die;
					}
        	    }
    	    }
	    }
    	closedir($dir);
		return true;
	}


	public function mysql_import($filename) {
		$prefix = '';

		$return = false;
		$sql_start = array('INSERT', 'UPDATE', 'DELETE', 'DROP', 'GRANT', 'REVOKE', 'CREATE', 'ALTER');
		$sql_run_last = array('INSERT');

		if (file_exists($filename)) {
			$lines = file($filename);
			$queries = array();
			$query = '';

			if (is_array($lines)) {
				foreach ($lines as $line) {
					$line = trim($line);

					if(!preg_match("'^--'", $line)) {
						if (!trim($line)) {
							if ($query != '') {
								$first_word = trim(strtoupper(substr($query, 0, strpos($query, ' '))));
								if (in_array($first_word, $sql_start)) {
									$pos = strpos($query, '`')+1;
									$query = substr($query, 0, $pos) . $prefix . substr($query, $pos);
								}

								$priority = 1;
								if (in_array($first_word, $sql_run_last)) {
									$priority = 10;
								}

								$queries[$priority][] = $query;
								$query = '';
							}
						} else {
							$query .= $line;
						}
					}
				}

				ksort($queries);

				foreach ($queries as $priority=>$to_run) {
					foreach ($to_run as $i=>$sql) {
						$sqlQueries[] = $sql;
					}
				}
				return $sqlQueries;
			}
		}
	}


/**
 * If its the first upload of the files we want index() and site() to be allowed.
 * If it is not the first upload then we want access to index() and site() to be restricted.
 */
	protected function _handleSecurity() {
		$userRoleId = $this->Session->read('Auth.User.user_role_id');
		$siteDir = defined('SITE_DIR') ? SITE_DIR : null;
		if ($siteDir && defined('IS_ZUHA')) {
			return true;
		} else if (!empty($siteDir) && $userRoleId != 1) {
			$this->Session->setFlash(__('Install access restricted.'));
			$this->redirect('/users/users/login');
		}
		return true;
	}
}
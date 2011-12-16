<?php

App::uses('CakeSchema', 'Model');
	
	
class InstallController extends AppController {

	public $name = 'Install';
    public $uses = array();
	public $dbVersion = __SYSTEM_ZUHA_DB_VERSION;
	public $params;
	public $progress;
	public $options;
	public $config;

/**
 * Schema class being used.
 *
 * @var CakeSchema
 */
	public $Schema;
	
	public function __construct($request = null, $response = null) {
		parent::__construct($request, $response);
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
	
	
	private function _out($out) {
		debug($out);
	}
	
	
	public function index() {
		if (!empty($this->request->data)) :
			// @todo  Move everything within from this if down into its own _install() function
			$dataSource = $this->request->data['Database'];
			#$db =& ConnectionManager::loadDataSource('install');
			$this->options['siteName'] = $this->request->data['Install']['site_name'];
			$this->options['siteDomain'] = $this->request->data['Install']['site_domain'] == 'mydomain.com' ? '' : $this->request->data['Install']['site_domain'];
			$this->config['host'] = $dataSource['host'];
			$this->config['login'] = $dataSource['username'];
			$this->config['password'] = $dataSource['password'];
			$this->config['database'] = $dataSource['name'];
			$this->newDir = ROOT.DS.'sites'.DS.$this->options['siteDomain'];
			
			
			$db = ConnectionManager::getDataSource('default');
			$db->disconnect();
			$db->setConfig($this->config);
			$db->connect();
			
			# test the db connection to make sure the info is good.
			if ($db->connected) :
				try {
					# test the table name
					$sql = ' SHOW TABLES IN ' . $this->config['database'];
					$db->execute($sql);
					# run the core table queries
					$this->_create();
					if ($this->lastTableName == $this->progress) : 
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
						if ($users && $webpages && $contacts && $galleries) :
							# run the required data
							if ($install = $this->_installCoreData($db)) :
								if ($this->_installCoreFiles()) : 
									$this->Session->setFlash(__('Database and files installed successfully ' . $install));
									$this->redirect($this->referer());
								else : 
									$this->Session->setFlash(__('File copy failed.' . $install));
									$this->redirect($this->referer());
								endif;
							else :
								$this->Session->setFlash(__('Database data insert broke (schema completed).'));
								$this->redirect($this->referer());
							endif;								
						else : 
							$this->Session->setFlash(__("Error : 
								Users: {$users}, 
								Webpages: {$webpages}, 
								Contacts: {$contacts}, 
								Galleries: {$galleries}"));
							$this->redirect($this->referer());
						endif;
					endif;
				} catch (PDOException $e) {
					$error = $e->getMessage();
					$db->disconnect();
					$this->Session->setFlash(__('Database Error : ' . $error));
					$this->redirect($this->referer());
				}
			else :
				$db->disconnect();
				$this->Session->setFlash(__('Database Connection Failed'));
				$this->redirect($this->referer());
			endif;
			
			#debug($this->Schema);
			#debug($this->request->data);
			#break;
		endif;
		
		$this->layout = false;
	}
	

/**
 * Copies example.com, creates the database.php, and core.php files.
 * 
 * @todo 		Probably should change this to catch throw syntax because there are a lot of errors with no feedback.
 */
	private function _installCoreFiles() {
		if (!empty($this->options['siteDomain']) && !empty($this->config)) : 
			# copy example.com
			$templateDir = ROOT.DS.'sites'.DS.'example.com';
			
			if ($this->_copy_directory($templateDir, $this->newDir)) :
				# create database.php
				$fileName = $this->newDir.DS.'Config'.DS.'database.php';
				$contents = "<?php".PHP_EOL.PHP_EOL."class DATABASE_CONFIG {".PHP_EOL.PHP_EOL."\tpublic \$default = array(".PHP_EOL."\t\t'datasource' => 'Database/Mysql',".PHP_EOL."\t\t'persistent' => false,".PHP_EOL."\t\t'host' => '".$this->config['host']."',".PHP_EOL."\t\t'login' => '".$this->config['login']."',".PHP_EOL."\t\t'password' => '".$this->config['password']."',".PHP_EOL."\t\t'database' => '".$this->config['database']."',".PHP_EOL."\t\t'prefix' => '',".PHP_EOL."\t\t//'encoding' => 'utf8',".PHP_EOL."\t);".PHP_EOL."}";
				if ($this->_createFile($fileName, $contents)) : 
					# create core.php
					if (copy($this->newDir.DS.'Config'.DS.'core.default.php', $this->newDir.DS.'Config'.DS.'core.php')) :
						# run settings
						return true;
					else :
						return false;
					endif;
				else :
					return false;
				endif;
			else : 
				return false;
			endif;			
		else:
			return false;
		endif;
	}
	
	
	private function _createFile($fileName = null, $contents = null) {
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
	
	
	/** will be deleted */
	public function login() {
		App::uses('User', 'Users.Model');
		$User = new User;
		$user = $User->find('first', array('conditions' => array('User.username' => 'admin')));
		debug($user);
		break;
		
		if (!empty($this->request->data)) {
			if ($this->Auth->login()) {
				try {
					$this->User->loginMeta($this->request->data);
	        		return $this->redirect($this->Auth->redirect());
				} catch (Exception $e) {
					$this->Session->setFlash($e->getMessage());
					$this->Auth->logout();
				}
		    } else {
		        $this->Session->setFlash(__('Username or password is incorrect'), 'default', array(), 'auth');
		    }
		}
	}
	
	
	
	private function _installPluginSchema($name = null, $plugin = null) {
		if (!empty($name) && !empty($plugin)) : 
			$this->params['name'] = $name;
			$this->params['plugin'] = $plugin;
			$this->_create();
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
			$this->err(__d('cake_console', '%s could not be loaded', $this->Schema->path . DS . $this->Schema->file));
			$this->_stop();
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
	
	
	private function _installCoreData(&$db) {
		try {
			# run each data sql insert
			foreach ($this->_getInstallSqlData() as $sql) :
				$db->execute($sql);
			endforeach;
			return true;
		} catch (PDOException $e) {
			$error = $e->getMessage();
			return $error;
		}		
	}
	
	
/**
 * The least amount of sql needed to successfully install zuha.
 */
	private function _getInstallSqlData() {
		
		$options['siteName'] = !empty($this->options['siteName']) ? $this->options['siteName'] : 'My Site';
		
		$dataStrings[] = "INSERT INTO `aliases` (`id`, `plugin`, `controller`, `action`, `value`, `name`, `created`, `modified`) VALUES
(1, 'webpages', 'webpages', 'view', 1, 'home', '2011-12-15 22:46:29', '2011-12-15 22:47:07');";
		
		$dataStrings[] = "INSERT INTO `aros` (`id`, `parent_id`, `model`, `foreign_key`, `alias`, `lft`, `rght`) VALUES (1, NULL, 'UserRole', 1, NULL, 1, 4), (2, NULL, 'UserRole', 2, NULL, 5, 6), (3, NULL, 'UserRole', 3, NULL, 7, 8), (6, 1, 'User', 1, NULL, 2, 3), (5, NULL, 'UserRole', 5, NULL, 9, 10);";
		
		$dataStrings[] = "INSERT INTO `contacts` (`id`, `name`, `contact_type_id`, `contact_source_id`, `contact_industry_id`, `contact_rating_id`, `user_id`, `is_company`, `creator_id`, `modifier_id`, `created`, `modified`) VALUES
('4eea7b66-6fb4-4635-93b5-0b28124e0d46', 'Zuha Administrator', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2011-12-15 22:57:42', '2011-12-15 22:57:42');";

		$dataStrings[] = "INSERT INTO `settings` (`id`, `type`, `name`, `value`, `description`, `plugin`, `model`, `created`, `modified`) VALUES (1, 'System', 'ZUHA_DB_VERSION', '0.0143', '', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'), (2, 'System', 'GUESTS_USER_ROLE_ID', '5', '', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'), (3, 'System', 'LOAD_PLUGINS', 'plugins[] = Users\r\nplugins[] = Webpages\r\nplugins[] = Contacts\r\nplugins[] = Galleries\r\nplugins[] = Privileges', '', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'), (4, 'System', 'SITE_NAME', '".$options['siteName']."', '', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00');";

		$dataStrings[] = "INSERT INTO `users` (`id`, `parent_id`, `reference_code`, `full_name`, `first_name`, `last_name`, `username`, `password`, `email`, `view_prefix`, `last_login`, `forgot_key`, `forgot_key_created`, `forgot_tries`, `user_role_id`, `credit_total`, `slug`, `created`, `modified`, `facebook_id`, `is_active`) VALUES
(1, NULL, 'lqnvph9u', 'Zuha Administrator', 'Zuha', 'Administrator', 'admin', '3eb13b1a6738103665003dea496460a1069ac78a', 'admin@example.com', 'admin', '2011-12-16 01:47:58', NULL, '2011-12-15 10:57:42', NULL, 1, 0, NULL, '2011-12-15 22:57:42', '2011-12-16 13:47:58', NULL, 0);";

		$dataStrings[] = "INSERT INTO `user_roles` (`id`, `parent_id`, `name`, `lft`, `rght`, `view_prefix`, `is_system`, `created`, `modified`) VALUES (1, NULL, 'admin', 1, 2, 'admin', 0, '0000-00-00 00:00:00', '2011-12-15 22:55:24'), (2, NULL, 'managers', 3, 4, '', 0, '0000-00-00 00:00:00', '2011-12-15 22:55:41'), (3, NULL, 'users', 5, 6, '', 0, '0000-00-00 00:00:00', '2011-12-15 22:55:50'), (5, NULL, 'guests', 7, 8, '', 0, '0000-00-00 00:00:00', '2011-12-15 22:56:05');";

		$dataStrings[] = "INSERT INTO `webpages` (`id`, `name`, `title`, `content`, `start_date`, `end_date`, `published`, `keywords`, `description`, `is_default`, `template_urls`, `user_roles`, `creator_id`, `modifier_id`, `created`, `modified`) VALUES
(1, 'Homepage', '', 'Congratulations!&nbsp;&nbsp; Welcome to the first page of your new Zuha install.&nbsp;&nbsp; ', NULL, NULL, NULL, '', '', 0, '', '', 1, 1, '2011-12-15 22:46:29', '2011-12-15 22:47:07');";

		return $dataStrings;
		
	}
	
	
	
	
/**
 * recurisive directory copying
 *
 * @todo 		Needs an error to return false
 */	
	private function _copy_directory($src, $dst) {
	    $dir = opendir($src);
	    @mkdir($dst);
	    while(false !== ( $file = readdir($dir)) ) {
	        if (( $file != '.' ) && ( $file != '..' )) {
	            if ( is_dir($src . '/' . $file) ) {
	                $this->_copy_directory($src . '/' . $file,$dst . '/' . $file);
    	        } else {
            	    copy($src . '/' . $file,$dst . '/' . $file);
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
}
?>




<?php /*
  	if (isset($_POST['database'])) {
		$host = $_POST['host'];
		$login = $_POST['login'];
		$password = $_POST['password'];
		$database = $_POST ['database'];
		$connection = mysql_connect($host, $login, $password);
		if ($connection) {
			# connect works now lets see if we can put the data in		
			# we have the query to import db, lets run it
			mysql_select_db($database);
			# opne the sqlFile
			$sqlFile = "../../0.01.sql";	
			# put the queries into an array
####################################$sqlQuery = mysql_import($sqlFile);
			#echo '<pre>';
			#print_r($sqlQuery);
			#echo '</pre>';
			#break;
			# run the queries
			foreach ($sqlQuery as $query) {
				$result = mysql_query($query);
				if (!$result) {
					$message  = '<p>Invalid query: ' . mysql_error() . '</p>';
					$message .= '<p>Whole query: ' . $query . '</p>';
					die($message);
				}
			}
			# it must have worked it didn't die
			# successful database import lets write the db file
			$configFile = "../config/database.php";
			$fh = fopen($configFile, 'w') or die("can't open config file");
			$stringData = "<?php
class DATABASE_CONFIG {

	var \$default = array(
		'driver' => 'mysql',
		'persistent' => false,
		'host' => '$host',
		'login' => '$login',
		'password' => '$password',
		'database' => '$database',
	);
	
	function __construct() {
		if (file_exists('../'.WEBROOT_DIR.'/install.php')) {
			require_once ('../'.WEBROOT_DIR.'/install.php'); 
		}
	}
}
?>";
			fwrite($fh, $stringData);
			fclose($fh);

			# clear the post var
			unset($_POST);
			?>
			<p>Successfully installed you must now delete the install.php file to use zuha.  Would you like us to try for you?</p>
			<form action="" method="post">
            <input type="hidden" name="finish-install" value="true">
	        <input type="submit" name="submit" value="Finish Installtion">
            </form>
            <?php
			# close the connection
			mysql_close($connection);
		
		} else {
			unset($_POST);
            echo '<p>Could not connect to the database. <a href="install.php">Try again</a>?</p>';
		}
  ?>
  <?php 
	} else if (isset($_POST['finish-install'])) {
		# try to delete this file, because installation is done
		if(unlink('install.php')) {
			header('Location: /');
		} else {
			'<p>Could not delete the install file, you must do it manually.</p>';
		}
	} else {
  ?> 
  
  
  
  
  */ ?>
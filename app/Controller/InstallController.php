<?php

App::uses('CakeSchema', 'Model');

/**
 * Install Controller
 * 
 * Note: that we extend controller and NOT AppController
 */
class InstallController extends Controller {

    public $name = 'Install';
    public $uses = array();
    public $noDb = array('Utils');
    public $params;
    public $progress;
    public $options;
    public $config;
    public $installPlugins = array();
    public $message = '';
    public $allowedActions = array('index', 'site', 'login', 'plugin');
	public $local = false;
	public $installFile = '';

/**
 * Schema class being used.
 *
 * @var CakeSchema
 */
    public $Schema;

/**
 * Constructor
 * 
 */
    public function __construct($request = null, $response = null) {
    	
    	$this->helpers[] = 'Utils.Tree';
		
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
    	
        $this->options['siteName'] = Inflector::camelize(Inflector::underscore(str_replace(' ', '', $this->request->data['Install']['site_name'])));
        if (strpos($this->request->data['Install']['site_domain'], ',')) {
            // comma separated domain handler
            $this->siteDomains = array_map('trim', explode(',', $this->request->data['Install']['site_domain']));
            $this->options['siteDomain'] = $this->siteDomains[0];
        } else {
            $this->options['siteDomain'] = $this->request->data['Install']['site_domain'] == 'mydomain.com' ? '' : $this->request->data['Install']['site_domain'];
        }

        $this->options['key'] = !empty($this->request->data['Install']['key']) ? $this->request->data['Install']['key'] : null;

    	if (empty($data['Database']['host']) && $this->local === true) {
    		$this->_createDatabase();
    	} else {
	        $this->config['datasource'] = 'Database/Mysql';
	        $this->config['host'] = $data['Database']['host'];
	        $this->config['login'] = $data['Database']['username'];
	        $this->config['password'] = $data['Database']['password'];
	        $this->config['database'] = $data['Database']['name'];
    	}
        $this->newDir = ROOT . DS . 'sites' . DS . $this->options['siteDomain'];

        $this->options['first_name'] = !empty($this->request->data['User']['first_name']) ? $this->request->data['User']['first_name'] : $this->options['siteName'];
        $this->options['last_name'] = !empty($this->request->data['User']['last_name']) ? $this->request->data['User']['last_name'] : 'Administrator';
        $this->options['username'] = !empty($this->request->data['User']['username']) ? $this->request->data['User']['username'] : 'admin';
        //$this->options['password'] = !empty($this->request->data['User']['password']) ? $this->request->data['User']['password'] : '123';

        if (!empty($this->request->data['User']['password'])) {
            App::uses('AuthComponent', 'Controller/Component');
            $this->options['password'] = AuthComponent::password($this->request->data['User']['password']);
        } else {
            $this->options['password'] = '3eb13b1a6738103665003dea496460a1069ac78a'; // test
        }

        if (!empty($this->request->data['Install']['plugins'])) {
            foreach ($this->request->data['Install']['plugins'] as $name) {
                $this->installPlugins[$name] = $name;
            }
        }

        if (is_dir($this->newDir)) {
            $this->message[] = __('That domain already exists, please try again.');
            $this->_redirect($this->referer());
        }
    }

/**
 * Create database method
 * 
 */
 	protected function _createDatabase() {
		require($this->installFile);
		$Install = new INSTALL_CONFIG;
		
	    $this->config['datasource'] = 'Database/Mysql';
	    $this->config['host'] = $Install->default['host'];
	    $this->config['login'] = $Install->default['login'];
	    $this->config['password'] = $Install->default['password'];
	    $this->config['database'] = $Install->default['prefix'].str_replace($Install->default['postfix'], '', $this->request->data['Install']['site_domain']);
		
		// create the db here
		$connection = mysqli_connect($this->config['host'], $this->config['login'], $this->config['password']);
		
		// Check connection
		if (mysqli_connect_errno()) {
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		
		// See if database exists
		$dbTest = mysqli_select_db($connection, $this->config['database']);
		if ($dbTest) {
			$this->Session->setFlash(__('Cannot use db name : %s', $this->config['database']));
			$this->redirect('/install/site');
		} else {
			// Create database
			$sql = 'CREATE DATABASE `' . $this->config['database'] . '` COLLATE `utf8_general_ci`';
			if (mysqli_query($connection, $sql)) {
				return true;
			} else {
				throw new Exception('Error creating database');
			}
		}
	}
	

/**
 * Uninstall method
 */
	public function uninstall($plugin = null) {
        $this->set('plugins', $plugins = CakePlugin::loaded());
		if ($this->request->is('post')) {
			$loadedPlugins = unserialize(__SYSTEM_LOAD_PLUGINS);
			// get rid of the unstall plugin value
			unset($loadedPlugins['plugins'][array_search($plugin, $loadedPlugins['plugins'])]);
            $sqlData = '';
            foreach ($loadedPlugins['plugins'] as $sql) {
                $sqlData .= 'plugins[] = ' . $sql . PHP_EOL;
            }
			// now save the new setting value
			App::uses('Setting', 'Model');
            $Setting = new Setting;
            $data['Setting']['type'] = 'System';
            $data['Setting']['name'] = 'LOAD_PLUGINS';
            $data['Setting']['value'] = $sqlData;
            if ($Setting->add($data)) {
                $this->message[] = __('Plugin successfully uninstalled.');
                $this->_redirect(array('action' => 'index'));
            } else {
                $this->message[] = __('Settings update failed.');
            }
		}
	}
	
    public function index() {
        $this->_handleSecurity();
        $currentlyLoadedPlugins = CakePlugin::loaded();

        CakePlugin::loadAll();
        $unloadedPlugins = array_diff(CakePlugin::loaded(), $currentlyLoadedPlugins);

        foreach ($unloadedPlugins as $unloadedPlugin) {
            // unload the plugins just loaded
            CakePlugin::unload($unloadedPlugin);
        }

        if (!empty($unloadedPlugins)) {
            $this->set(compact('unloadedPlugins'));
        } elseif (empty($unloadedPlugins) && defined('SITE_DIR')) {
            // continue
        } else {
            $this->_redirect(array('action' => 'site'));
        }
        $this->set('page_title_for_layout', 'Install');
    }

/**
 * Install a plugin to the current site.
 */
    public function plugin($plugin = null) {
        $this->_handleSecurity();
        if (!empty($plugin) && defined('__SYSTEM_LOAD_PLUGINS')) {
            CakePlugin::load($plugin);
            if ($this->_installPluginSchema($plugin, $plugin)) {
                $plugins = unserialize(__SYSTEM_LOAD_PLUGINS);
                $sqlData = '';
                foreach ($plugins['plugins'] as $sql) {
                    $sqlData .= 'plugins[] = ' . $sql . PHP_EOL;
                }
                $sqlData = $sqlData . "plugins[] = {$plugin}";
                // "UPDATE `settings` SET `value` = 'plugins[] = Users\r\nplugins[] = Webpages\r\nplugins[] = Contacts\r\nplugins[] = Galleries\r\nplugins[] = Privileges' WHERE `name` = 'LOAD_PLUGINS';";
                App::uses('Setting', 'Model');
                $Setting = new Setting;
                $data['Setting']['type'] = 'System';
                $data['Setting']['name'] = 'LOAD_PLUGINS';
                $data['Setting']['value'] = $sqlData;
                if ($Setting->add($data)) {
                    $this->message[] = __('Plugin successfully installed.');
                    $this->_redirect(array('action' => 'index'));
                } else {
                    $this->message[] = __('Settings update failed.');
                    $this->_redirect(array('action' => 'index'));
                }
            } else {
                $this->message[] = __('Plugin install failed.');
                $this->_redirect(array('action' => 'index'));
            }
        } else {
            $this->message[] = __('Current plugin setup not valid.');
            $this->_redirect(array('action' => 'index'));
        }
    }

/**
 * Install a new site
 *
 * @todo      We need some additional security on this.
 */
    public function site() {
        $this->_handleSecurity();
        $this->set('local', $this->_local());
		
        if (!empty($this->request->data)) {
          	$this->_handleInputVars($this->request->data);
            // move everything here down to its own function
            try {
            	CakePlugin::loadAll(); // needed to make sure we don't get some stupid error
                $db = ConnectionManager::create('default', $this->config);
                try {
                    // test the table name
                    $sql = ' SHOW TABLES IN ' . $this->config['database'];
                    $db->execute($sql);
                    // run the core table queries
                    $this->_create($db);
                    if ($this->lastTableName == $this->progress) {
                        // run the required plugins
                        if ($this->_installPluginSchema('Users', 'Users')) {
                            $users = true;
                        }
                        if ($this->_installPluginSchema('Webpages', 'Webpages')) {
                            $webpages = true;
                        }
                        if ($this->_installPluginSchema('Contacts', 'Contacts')) {
                            $contacts = true;
                        }
                        if ($this->_installPluginSchema('Galleries', 'Galleries')) {
                            $galleries = true;
                        }
                        // extra plugins to install for this site
                        if (!empty($this->installPlugins)) {
                            foreach ($this->installPlugins as $name => $plugin) {
                                if ($this->_installPluginSchema($name, $plugin)) {
                                    $extras = true;
                                } else {
                                    $extras = false;
                                    break;
                                }
                            }
                        } else {
                            $extras = true;
                        }
                        if ($users && $webpages && $contacts && $galleries && $extras) {
                            // run the required data
                            try {
                                $this->_installCoreData($db);
                            } catch (Exception $e) {
                                throw new Exception($e->getMessage());
                            }

                            try {
                                $this->_installCoreFiles();
                                // success!!!
                                $this->message[] = __('Success');
                                $this->_redirect('http://' . $this->options['siteDomain'] . '/settings/install');
                            } catch (Exception $e) {
                                throw new Exception(__('File copy failed. %s', $e->getMessage()));
                            }
                        } else {
                            throw new Exception(__("Error :
				                Users: {$users},
				                Webpages: {$webpages},
				                Contacts: {$contacts},
				                Galleries: {$galleries},
                                Extras: {$extras}"));
                        }
                    } else {
                    	debug($this->lastTableName);
						debug($this->progress);
						break;
                    }
                } catch (PDOException $e) {
                    $error = $e->getMessage();
                    $db->disconnect();
                    $this->message[] = __('Database Error : ' . $error);
                    $this->_redirect($this->referer());
                }
            } catch (Exception $e) {
                $this->message[] = __('Database Connection Failed. ' . $e->getMessage());
                $this->_redirect($this->referer());
            }
        } // end request data check
        $this->layout = false;
    }

/**
 * Local method
 * Checks for .install.php file and if exists, returns true
 * 
 */
 	protected function _local() {
 		$file = ROOT . DS . APP_DIR . DS . 'Config' . DS . '.install.php';
 		if (file_exists($file)) {
 			$this->installFile = $file;
 			$this->local = true;
 			$this->view = 'local';
 			return true;
 		}
 	}

/**
 * Copies example.com, creates the database.php, and core.php files.
 *
 * @todo     Probably should change this to catch throw syntax because there are a lot of errors with no feedback.
 */
    protected function _installCoreFiles() {
        if (!empty($this->options['siteDomain']) && !empty($this->config)) {
            // copy example.com
            $templateDir = ROOT . DS . 'sites' . DS . 'example.com';

            if ($this->_copy_directory($templateDir, $this->newDir)) {
                // create database.php
                $fileName = $this->newDir . DS . 'Config' . DS . 'database.php';
                $contents = "<?php" . PHP_EOL . PHP_EOL . "class DATABASE_CONFIG {" . PHP_EOL . PHP_EOL . "\tpublic \$default = array(" . PHP_EOL . "\t\t'datasource' => 'Database/Mysql'," . PHP_EOL . "\t\t'persistent' => false," . PHP_EOL . "\t\t'host' => '" . $this->config['host'] . "'," . PHP_EOL . "\t\t'login' => '" . $this->config['login'] . "'," . PHP_EOL . "\t\t'password' => '" . $this->config['password'] . "'," . PHP_EOL . "\t\t'database' => '" . $this->config['database'] . "'," . PHP_EOL . "\t\t'prefix' => ''," . PHP_EOL . "\t\t//'encoding' => 'utf8'," . PHP_EOL . "\t);" . PHP_EOL . "}";
                if ($this->_createFile($fileName, $contents)) {
                    // update sites/bootstrap.php
                    if ($this->_updateBootstrapPhp()) {
                        // run settings
                        return true;
                    } else {
                        $this->message[] = __('Update bootstrap failed');
                        $this->_redirect($this->referer());
                    }
                } else {
                    $this->message[] = __('Database file update failed.');
                    $this->_redirect($this->referer());
                }
            } else {
                $this->message[] = __('Copy site directory failed.');
                $this->_redirect($this->referer());
            }
        } else {
            $this->message[] = __('Empty site domain, or empty config');
            $this->_redirect($this->referer());
        }
    }

    protected function _updateBootstrapPhp() {
        $filename = ROOT . DS . 'sites' . DS . 'bootstrap.php';
        $filesize = filesize($filename);
        $file = fopen($filename, 'r');
        $filecontents = fread($file, $filesize);
        fclose($file);

        if (!empty($this->siteDomains)) {
            $replace = '';
            foreach ($this->siteDomains as $site) {
                $replace .= "\$domains['" . $site . "'] = '" . $this->options['siteDomain'] . "';" . PHP_EOL;
            }
        } else {
            $replace = "\$domains['" . $this->options['siteDomain'] . "'] = '" . $this->options['siteDomain'] . "';" . PHP_EOL;
        }

        // make a back up first
        if (copy($filename, ROOT . DS . 'sites' . DS . 'bootstrap.' . date('Ymdhis') . '.php')) {
            $contents = str_replace('/** end **/', $replace . PHP_EOL . '/** end **/', $filecontents);
            if (file_put_contents($filename, $contents)) {
                return true;
            }
        }
        return false;
    }

    protected function _createFile($fileName = null, $contents = null) {
        $fh = fopen($fileName, 'w') or die("can't open file");
        if (fwrite($fh, $contents)) {
            fclose($fh);
            return true;
        }

        return false;
    }

    protected function _installPluginSchema($name = null, $plugin = null) {
        if (!empty($name) && !empty($plugin)) {
            if (in_array($plugin, $this->noDb)) {
                $this->message[] = __('( no database tables modifications required )');
                return true;
            } else {
                $this->params['name'] = $name;
                $this->params['plugin'] = $plugin;
                $this->_create($blank = '');
                if ($this->lastTableName == $this->progress) {
                    return true;
                } else {
                    return false;
                }
            }
        } else {
            return false;
        }
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
            $this->message[] = __(' ( could not load %s database schema ) ', $options['name']);
            $this->_redirect($this->referer());
        }
        $table = null;
        if (isset($this->args[1])) {
            $table = $this->args[1];
        }
        return array(&$Schema, $table);
    }

/**
 * Create database tables from Schema object
 *
 * @param CakeSchema $Schema
 * @param string $table
 * @return bool
 */
    protected function _create($Schema, $table = null) {
        list($Schema, $table) = $this->_loadSchema();
        if (is_object($Schema)) {
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
            $end = $create;
            end($end);
            $this->lastTableName = key($end); // get the last key in the array
            $this->_run($drop, 'drop', $Schema);
            $this->_run($create, 'create', $Schema);
        } else {
            $this->message[] = __('( schema  )');
            debug($this->message);
            break;
            return false;
        }
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
                        $error = $table . ': ' . $e->getMessage();
                    }

                    $Schema->after(array($event => $table, 'errors' => $error));

                    if (!empty($error)) {
                        //$this->err($error);
						$this->message[] = __('<b>Database Error : </b>' . $error);
						$this->_redirect($this->referer());
                    } else {
                        $this->progress = $table;
                        //$this->_out(__d('cake_console', '%s updated.', $table));
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
        // run each data sql insert
        foreach ($this->_getInstallSqlData() as $sql) {
            try {
                $db->query($sql);
            } catch (PDOException $e) {
                throw new Exception($e->getMessage());
            }
        }
        return true;
    }

/**
 * Creates the sites folder if it doesn't exist as a copy of sites.default
 */
    protected function _handleSitesDirectory() {
        if (@!is_writable(ROOT . DS . 'app' . DS . 'tmp' . DS . 'logs')) {
            $errorOne = '<ul><li>Please give write permissions to the <strong>' . ROOT . DS . 'app' . DS . 'tmp' . DS . 'logs</strong> directory. </li></ul>';
            $die = true;
        }
        if (@!is_writable(ROOT . DS . 'sites')) {
            $errorTwo = '<ul><li>Please give write permissions to the <strong>' . ROOT . DS . 'sites</strong> directory. </li></ul>';
            $die = true;
        }
        if (!empty($die) && $die === true) {
            echo '<h1>Problem with server compatibility.</h1>';
            echo $errorOne ? $errorOne : null;
            echo $errorTwo ? $errorTwo : null;
            die;
        }

        if (file_exists(ROOT . DS . 'sites.default') && !file_exists(ROOT . DS . 'sites/example.com')) {
            if ($this->_copy_directory(ROOT . DS . 'sites.default', ROOT . DS . 'sites')) {
                
            } else {
                echo 'Please update write permissions for the "sites" directory.';
                die;
            }
        }
    }

/**
 * recurisive directory copying
 *
 * @todo     Needs an error to return false
 */
    protected function _copy_directory($src, $dst) {
        $dir = opendir($src);
        @mkdir($dst);
        while (false !== ( $file = readdir($dir))) {
            if (( $file != '.' ) && ( $file != '..' )) {
                if (is_dir($src . '/' . $file)) {
                    $this->_copy_directory($src . '/' . $file, $dst . '/' . $file);
                } else {
                    if (copy($src . '/' . $file, $dst . '/' . $file)) {
                        
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

                    if (!preg_match("'^--'", $line)) {
                        if (!trim($line)) {
                            if ($query != '') {
                                $first_word = trim(strtoupper(substr($query, 0, strpos($query, ' '))));
                                if (in_array($first_word, $sql_start)) {
                                    $pos = strpos($query, '`') + 1;
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

                foreach ($queries as $priority => $to_run) {
                    foreach ($to_run as $i => $sql) {
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
    	//this is here to handle post install redirect (so that it wouldn't come back to the install page)
    	if (defined('SITE_DIR') && SITE_DIR == 'sites/'.$_SERVER['HTTP_HOST'] && $this->request->action != 'index' && $this->request->action != 'plugin') {
			$this->Session->setFlash(__('Site installed successfully.')); 
			$this->redirect('/install/build');
		}
		
    	if (Configure::read('Install') === true) {
    		return true;
    	}
        $userRoleId = !empty($userRoleId) ? $userRoleId : $this->Session->read('Auth.User.id');
        if ((defined('SITE_DIR') && SITE_DIR && $userRoleId != 1) || Configure::read('Install') === false) {
            $this->message[] = __('Install access restricted.');
            $this->_redirect('/users/users/login');
        }
        return true;
    }

/**
 * Install Sql Data
 */
    protected function _getInstallSqlData() {
        $installedPlugins = 'plugins[] = Users\r\nplugins[] = Webpages\r\nplugins[] = Contacts\r\nplugins[] = Galleries\r\nplugins[] = Privileges\r\nplugins[] = Utils';
        if (!empty($this->installPlugins)) {
            foreach ($this->installPlugins as $pluginName) {
                $installedPlugins .= '\r\nplugins[] = ' . $pluginName;
            }
        }
        $options['siteName'] = !empty($this->options['siteName']) ? $this->options['siteName'] : 'My Site';

        $dataStrings[] = "INSERT INTO `aros` (`id`, `parent_id`, `model`, `foreign_key`, `alias`, `lft`, `rght`) VALUES 
(1, NULL, 'UserRole', 1, NULL, 1, 4), 
(5, NULL, 'UserRole', 5, NULL, 5, 6),
(6, 1, 'User', 1, NULL, 2, 3);";

        $dataStrings[] = "INSERT INTO `contacts` (`id`, `name`, `user_id`, `is_company`, `created`, `modified`) VALUES
('1', 'Administrator', 1, 0, '" . date('Y-m-d h:i:s') . "', '" . date('Y-m-d h:i:s') . "');";

        $dataStrings[] = "INSERT INTO `settings` (`id`, `type`, `name`, `value`, `description`, `plugin`, `model`, `created`, `modified`) VALUES
('50dd24cc-2c50-50c0-a96b-4cf745a3a949', 'System', 'GUESTS_USER_ROLE_ID', '5', '', NULL, NULL, '" . date('Y-m-d h:i:s') . "', '" . date('Y-m-d h:i:s') . "'),
('50dd24cc-2c50-51c0-a96b-4cf745a3a949', 'System', 'LOAD_PLUGINS', '" . $installedPlugins . "', '', NULL, NULL, '" . date('Y-m-d h:i:s') . "', '" . date('Y-m-d h:i:s') . "'),
('50dd24cc-2c50-52c0-a96b-4cf745a3a949', 'System', 'SITE_NAME', '" . $options['siteName'] . "', '', NULL, NULL, '" . date('Y-m-d h:i:s') . "', '" . date('Y-m-d h:i:s') . "'),
('50e08ff5-d88c-42d3-9c99-726745a3a949', 'System', 'SMTP', 'smtp = \"K7qTTLH17Ja5XTUiHLtnNiY2i8kg0XnVvnYli5MYtZJViOL7lvlfNyoxjDQ1Myi0hiuXOIj0PGfZx3q/0RnO1bCJ6h5VTU/rMygPN5eTeNlvlOssN8qANbaOUMrl5onaNisqSPYXNzUsxNp40HnSi1Ihlog199ociufni/lEbXEOvmk6KCykhS2NI4P0KmmHiDXa7VqW6eSqtlE9ZwGmZRoyMYiDKpZvqucxK8Y=\"', 'Defines email configuration settings so that sending email is possible. Please note that these values will be encrypted during entry, and cannot be retrieved.\r\n\r\nExample value : \r\nsmtpUsername = xyz@example.com\r\nsmtpPassword = \"XXXXXXX\"\r\nsmtpHost = smtp.example.com\r\nsmtpPort = XXX\r\nfrom = myemail@example.com\r\nfromName = \"My Name\"', NULL, NULL, '" . date('Y-m-d h:i:s') . "', '" . date('Y-m-d h:i:s') . "');";

        $dataStrings[] = "INSERT INTO `users` (`id`, `full_name`, `first_name`, `last_name`, `username`, `password`, `email`, `view_prefix`, `user_role_id`, `created`, `modified`) VALUES
('1', '" . $this->options['siteName'] . "', '" . $this->options['first_name'] . "', '" . $this->options['last_name'] . "', '" . $this->options['username'] . "', '" . $this->options['password'] . "', 'admin@example.com', 'admin', 1, '" . date('Y-m-d h:i:s') . "', '" . date('Y-m-d h:i:s') . "');";

        $dataStrings[] = "INSERT INTO `user_roles` (`id`, `parent_id`, `name`, `lft`, `rght`, `view_prefix`, `is_system`, `created`, `modified`) VALUES 
(1, NULL, 'admin', 1, 2, 'admin', 0, '" . date('Y-m-d h:i:s') . "', '" . date('Y-m-d h:i:s') . "'), 
(5, NULL, 'guests', 7, 8, '', 0, '" . date('Y-m-d h:i:s') . "', '" . date('Y-m-d h:i:s') . "');";

        $dataStrings = array_merge($dataStrings, $this->_insertExtraData());

        return $dataStrings;
    }

/**
 * Insert Data
 *
 * @todo Get these queries from the Config/schema files instead
 */
    protected function _insertExtraData() {
        $return = array();
        foreach ($this->installPlugins as $plugin) {
            if ($plugin == 'Blogs') {
                $return[] = "INSERT INTO `blogs` (`id`, `title`, `start_page`, `is_public`, `owner_id`, `creator_id`, `modifier_id`, `created`, `modified`) VALUES
('50e0662b-1564-4c63-a495-265745a3a949', 'Our Blog', '', 1, '1', '1', '1', '" . date('Y-m-d h:i:s') . "', '" . date('Y-m-d h:i:s') . "');";
                $return[] = "INSERT INTO `blog_posts` (`id`, `blog_id`, `title`, `introduction`, `text`, `status`, `tags`, `allow_comments`, `comments`, `author_id`, `creator_id`, `modifier_id`, `published`, `created`, `modified`) VALUES
('50e06747-6ca8-494b-83fc-265745a3a949', '50e0662b-1564-4c63-a495-265745a3a949', 'My First Blog Post', 'Why to blog?', '<p>A blog is an important tool for giving your expertise to the world to build trust and invite users to experience your brand and what you have to offer.</p>\r\n\r\n<p>To provide a good blog you should research what your audience needs.&nbsp; See if there are gaps of information that you can fill with your expertise and knowledge and maybe even an entertaining twist to make it easy and fun to read.&nbsp; (Oh and don&#39;t forget to add some images and video to really catch the eye.)</p>\r\n', 'published', NULL, 0, NULL, '1', NULL, NULL, '" . date('Y-m-d h:i:s') . "', '" . date('Y-m-d h:i:s') . "', '" . date('Y-m-d h:i:s') . "');";
            }
            if ($plugin == 'Forms') {
                $return[] = "INSERT INTO `forms` (`id`, `name`, `method`, `plugin`, `model`, `action`, `url`, `notifiees`, `success_message`, `success_url`, `fail_message`, `fail_url`, `response_email`, `response_subject`, `response_body`, `creator_id`, `modifier_id`, `created`, `modified`) VALUES
('50e1325f-1750-4bea-bfc5-102245a3a949', 'Contact Form', 'file', 'Contacts', 'Contact', 'add', '/contacts/contacts/add', '', 'Thank you.', '/home', 'Please try again.', '', '_method', '', '', '1', '1', '" . date('Y-m-d h:i:s') . "', '" . date('Y-m-d h:i:s') . "');";
                $return[] = "INSERT INTO `form_inputs` (`id`, `form_id`, `form_fieldset_id`, `code`, `name`, `show_label`, `model_override`, `input_type`, `system_default_value`, `default_value`, `option_values`, `option_names`, `before`, `between`, `separator`, `after`, `multiple`, `min_length`, `max_length`, `placeholder`, `legend`, `rows`, `columns`, `empty_text`, `time_format`, `date_format`, `min_year`, `max_year`, `minute_interval`, `div_id`, `div_class`, `error_message`, `is_unique`, `is_required`, `is_system`, `is_quicksearch`, `is_advancedsearch`, `is_comparable`, `is_layered`, `layer_order`, `is_not_db_field`, `is_visible`, `is_addable`, `is_editable`, `order`, `validation`, `validation_message`, `creator_id`, `modifier_id`, `created`, `modified`) VALUES
('50e13260-4da8-42aa-9d70-102245a3a949', '50e1325f-1750-4bea-bfc5-102245a3a949', NULL, 'name', 'Name', 1, NULL, 'text', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, NULL, NULL, NULL, '1', '1', '" . date('Y-m-d h:i:s') . "', '" . date('Y-m-d h:i:s') . "'),
('50e13260-7b44-4091-a329-102245a3a949', '50e1325f-1750-4bea-bfc5-102245a3a949', NULL, 'contact_detail_type', 'Contact Detail Type', 1, 'ContactDetail.0', 'hidden', NULL, 'Email', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, NULL, NULL, NULL, '1', '1', '" . date('Y-m-d h:i:s') . "', '" . date('Y-m-d h:i:s') . "'),
('50e13260-70b0-4f38-8bda-102245a3a949', '50e1325f-1750-4bea-bfc5-102245a3a949', NULL, 'value', 'Email', 1, 'ContactDetail.0', 'text', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, NULL, 'email', NULL, '1', '1', '" . date('Y-m-d h:i:s') . "', '" . date('Y-m-d h:i:s') . "'),
('50e13260-507c-4aef-8bf1-102245a3a949', '50e1325f-1750-4bea-bfc5-102245a3a949', NULL, 'contact_detail_type', 'Contact Detail Type Notes', 1, 'ContactDetail.1', 'hidden', NULL, 'Note', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, NULL, NULL, NULL, '1', '1', '" . date('Y-m-d h:i:s') . "', '" . date('Y-m-d h:i:s') . "'),
('50e13260-12fc-422f-91b4-102245a3a949', '50e1325f-1750-4bea-bfc5-102245a3a949', NULL, 'value', 'Comments', 1, 'ContactDetail.1', 'textarea', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, NULL, NULL, NULL, '1', '1', '" . date('Y-m-d h:i:s') . "', '" . date('Y-m-d h:i:s') . "'),
('50e13260-cb70-4643-a588-102245a3a949', '50e1325f-1750-4bea-bfc5-102245a3a949', NULL, 'current_page_url', 'Page URL', 1, 'ContactDetail.1', 'hidden', 'current page url', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, NULL, NULL, NULL, '1', '1', '" . date('Y-m-d h:i:s') . "', '" . date('Y-m-d h:i:s') . "');";
            }
        }
        return $return;
    }

/**
 * Redirect
 */
    protected function _redirect($url = null) {
        if (!empty($this->options['key'])) {
            if (in_array('Success', $this->message)) {
                echo 'Success';
                $this->layout = false;
                $this->render(false);
            } else {
                echo implode(', ', $this->message);
                $this->layout = false;
                $this->render(false);
            }
        } else {
            $this->Session->setFlash(implode(', ', $this->message));
            $this->redirect($url);
        }
    }

/**
 * Build method
 * 
 */
 	public function build() {
 		$this->layout = 'default';
		$this->set('plugins', CakePlugin::loaded());
		
		App::uses('UserRole', 'Users.Model');
		$UserRole = new UserRole;
		$this->set('userRoles', $userRoles = $UserRole->find('all'));
		$this->set('userRoleOptions', Set::combine($userRoles, '{n}.UserRole.session_user_role_id', '{n}.UserRole.name'));
		
		App::uses('Template', 'Model');
		$Template = new Template;
		$this->set('templates', $templates = $Template->find('all', array('conditions' => array('Template.install NOT' => null))));
		$this->set('page_title_for_layout', 'SITE buildrr');
		$this->set('title_for_layout', 'SITE buildrr');
		
		$defaultTemplate = Set::combine(templateSettings(), '{n}.isDefault', '{n}');
		$defaultTemplate = Set::extract('/Template[layout='.$defaultTemplate[1]['templateName'].']', $templates);
		$defaultTemplate = !empty($defaultTemplate) ? $defaultTemplate : $Template->placeholder();
		$this->set(compact('defaultTemplate'));
		
		$Menu = ClassRegistry::init('Webpages.WebpageMenu');
		foreach ($userRoles as $userRole) {
			$varName = $userRole['UserRole']['name'] . 'Sections';
			$conditions = $userRole['UserRole']['id'] == __SYSTEM_GUESTS_USER_ROLE_ID ? array('OR' => array(array('WebpageMenu.user_role_id' => ''), array('WebpageMenu.user_role_id' => null))) : array('WebpageMenu.user_role_id' => $userRole['UserRole']['id']);
        	$this->set($varName, $Menu->find('threaded', array('conditions' => $conditions)));
		}
        //$this->set('sections', $Menu->find('threaded', array('conditions' => array('WebpageMenu.lft >=' => $menu['WebpageMenu']['lft'], 'WebpageMenu.rght <=' => $menu['WebpageMenu']['rght']))));
        // used for re-ordering items $this->request->data['WebpageMenu']['children'] = $this->WebpageMenu->find('count', array('conditions' => array('WebpageMenu.lft >' => $menu['WebpageMenu']['lft'], 'WebpageMenu.rght <' => $menu['WebpageMenu']['rght'])));
		
		//$this->set('sections', $sections = $Menu->find('all', array('conditions' => array('OR' => array(array('WebpageMenu.parent_id' => null), array('WebpageMenu.parent_id' => ''))))));
		$menus = $Menu->generateTreeList(null, null, null, '--');
		foreach ($menus as $menu) {
			if (strpos($menu, '-') !== 0) {
				// this key should be removed, because if there is a link to the same page as the menu name
				$menus = ZuhaSet::devalue($menus, '--'.$menu, true);
			}
		}
		$this->set(compact('menus'));

 	}

/**
 * Template method
 * Installs a template as the default template for the site
 * 
 * @param string $id
 */
 	public function template($id) {
 		debug(array(		'install' => unserialize('a:7:{i:0;a:1:{s:7:"Webpage";a:3:{s:4:"type";s:8:"template";s:4:"name";s:10:"toggle.ctp";s:7:"content";s:3480:"<!DOCTYPE html><html lang="en">	<head>		<meta charset="utf-8">		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">		<meta name="viewport" content="width=device-width, initial-scale=1.0">		<link href="/favicon.ico" type="image/x-icon" rel="icon" />		<link href="/favicon.ico" type="image/x-icon" rel="shortcut icon" />		<title>Export toggle.ctp</title><!-- Bootstrap core CSS -->		<link href="/css/system.css" rel="stylesheet" />		<link href="/css/twitter-bootstrap.3/bootstrap.min.css" rel="stylesheet">		<link href="/css/twitter-bootstrap.3/bootstrap.custom.css" rel="stylesheet" />		<link rel="stylesheet" type="text/css" href="/theme/Default/css/toggle-custom.css" media="all" />		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->		<!--[if lt IE 9]>		<script src="/js/twitter-bootstrap.3/html5shiv.js"></script>		<script src="/js/twitter-bootstrap.3/respond.min.js"></script>		<![endif]-->		<script src="http://code.jquery.com/jquery-latest.js"></script>		<script src="/js/twitter-bootstrap.3/bootstrap.min.js"></script>		<script src="/js/twitter-bootstrap.3/bootstrap.custom.js"></script>		<script src="/js/system.js"></script>		<script type="text/javascript" src="/theme/Default/js/toggle-custom.js"></script>	</head>	<body class="webpages authorized export userRole1" id="webpages_export_3" lang="en">		<!--[if lt IE 7]><p class="chromeframe">You are using an outdated browser. <a href="http://browsehappy.com/">Upgrade your browser today</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to better experience this site.</p><![endif]-->		<div class="navbar navbar-fixed-top navbar-inverse" role="navigation">			<div class="container">				<div class="navbar-header">					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">						<span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>					</button>					<a class="navbar-brand" href="/">Demo</a>				</div>				<div class="collapse navbar-collapse">					{menu: main-menu class="nav navbar-nav",var=nothing}				</div><!-- /.nav-collapse -->			</div><!-- /.container -->		</div><!-- /.navbar -->		<div class="container">			<div class="row row-offcanvas row-offcanvas-right">				<div class="col-xs-12 col-sm-9">					<p class="pull-right visible-xs">						<button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">							Toggle nav						</button>					</p>					{helper: flash_for_layout}					{helper: flash_auth_for_layout}										{helper: content_for_layout}					<div class="row">						<div class="col-6 col-sm-6 col-lg-4">							{page: toggle-callout-one}						</div><!--/span-->						<div class="col-6 col-sm-6 col-lg-4">							{page: toggle-callout-two}						</div><!--/span-->						<div class="col-6 col-sm-6 col-lg-4">							{page: toggle-callout-three}						</div><!--/span-->					</div><!--/row-->				</div><!--/span-->				<div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar" role="navigation">					<div class="well sidebar-nav">						{page: toggle-sidebar}					</div><!--/.well -->				</div><!--/span-->			</div><!--/row-->			<hr>			<footer class="">				<div class="col-lg-6">					{page: toggle-footer-left}				</div>				<div class="col-lg-6 text-right">					{page: toggle-footer-right}				</div>			</footer>		</div><!--/.container-->	</body></html>";}}i:1;a:1:{s:7:"Webpage";a:3:{s:4:"type";s:7:"element";s:4:"name";s:18:"toggle-callout-one";s:7:"content";s:323:"  <h2>Heading</h2>  <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>  <p><a class="btn btn-default" href="#">View details Â»</a></p>";}}i:2;a:1:{s:7:"Webpage";a:3:{s:4:"type";s:7:"element";s:4:"name";s:18:"toggle-callout-two";s:7:"content";s:323:"  <h2>Heading</h2>  <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>  <p><a class="btn btn-default" href="#">View details Â»</a></p>";}}i:3;a:1:{s:7:"Webpage";a:3:{s:4:"type";s:7:"element";s:4:"name";s:20:"toggle-callout-three";s:7:"content";s:323:"  <h2>Heading</h2>  <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>  <p><a class="btn btn-default" href="#">View details Â»</a></p>";}}i:4;a:1:{s:7:"Webpage";a:3:{s:4:"type";s:7:"element";s:4:"name";s:14:"toggle-sidebar";s:7:"content";s:434:"<h4>EXAMPLE SIDEBAR</h4> <blockquote> <p>A great product from a great store! Glad I was able to purchase and get it so easily.</p> <small>Thomas Edison <cite title="Source Title">Wardenclyffe Tower</cite></small></blockquote> <blockquote> <p>It feels great to get customer service and a great product. Can&#39;t wait to come back for more.</p> <small>Galileo Galilei <cite title="Source Title">Vatican City</cite></small></blockquote>";}}i:5;a:1:{s:7:"Webpage";a:3:{s:4:"type";s:7:"element";s:4:"name";s:18:"toggle-footer-left";s:7:"content";s:230:"<p>&copy; 2013 <a href="/">{element: site-name}</a>. All Rights Reserved.<br><a href="http://buildrr.com" target="_blank" title="Create your own online store with buildrr.com hosted ecommerce">Ecommerce Software</a> by buildrr</p>";}}i:6;a:1:{s:7:"Webpage";a:3:{s:4:"type";s:7:"element";s:4:"name";s:19:"toggle-footer-right";s:7:"content";s:59550:"<p class="socialmedia"><a href="http://www.youtube.com" target="_blank"><img height="48" src="data:image/png;base64,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" width="48" /></a> <a href="http://www.twitter.com" target="_blank"><img height="48" src="data:image/png;base64,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" width="48" /></a> <a href="http://www.facebook.com" target="_blank"><img height="48" src="data:image/png;base64,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" width="48" /></a></p>";}}}'
							)));
 		debug(array(
							'Template' => array(
								'layout' => 'toggle.ctp',
								'demo' => 'http://getbootstrap.com/examples/offcanvas/',
								'is_usable' => '0',
								'icon' => '<div style="height: 0px; padding-bottom: 80%; position:relative; width: 100%; float: left;"><div style="width: 100%; height: 100%; padding: 0; top: 0; position: absolute; background: url(data:image/gif;base64,R0lGODlhPAHtAMQAAAAAAP/u7qrM7oSx2oiIiERERN3d3aqqqjMzM3d3dyIiIpnM3ZmZmWZmZuHr8BEREVVVVczMzLu7u////+7u7s3d7P//7sHY6u7/8pe937vM3e7u/7nS6KrJ4tfk7oy22yH5BAAHAP8ALAAAAAA8Ae0AAAX/oCKOZGmeaKqWAPC8cAyvdG3feK7vfO//wKCQ1Soaj8OkcslsOp9Q33FqjFqv2Kx2+xJSv9uweEwumwoFxUwlM7ViX8AOgeia7/g8HtGAQNAFCGiCfg+DEISAJG8NCQ1oj39FJI+BgQgQJoKCgICYCHqhoqNDfIkFDamIaAp+EKlorw2gIowNBAQJrwcQk2qYfa5+mrGVsoOkycrLNHV0nYGrCs9/dJyLLl11dr4koNYodNMi1rTM5+jp5A88cVPq8PHyWNky9uzz+fpO9/3+/wADwnB3RKDBgwgTKlzIsKHDhxAXlptIsaLFixgzatzIsaPHjyBDihxJsqRJkhRS/6pcybKly5cwY8qcSbOmzZs4c+rcybOnz583JwgdSrSo0aNIkypdyrSp06dQo0qdSrWq1atYs2rdyrWr169gw4odS7as2bNo06pd+xWo27dw48p9e3QuXLZN7erdy7evz7p+e+JdGriw4cN862JYzLix48eQI0ue3HiwUsSYM2vWCXjzTMtJPYsePbozBaSNM4NGSrq1a8OdJ1AwcPq0bKKqVxt9zbv33NgSCEiIcECChAMRhkeQjVj3bt/Qo/OMHQEXAwYJruMiYID5YedFpYsfTzM2hQgG0qtXLxQzeNzk48tXado269zvvc/fL71+7/zt8ScgdP6lZMGBCG4GoP9+AzZIWoGvLejghA8+x5IDFWzQAQcZVMAgbABSKKKCFq7kQAcXoJgBBx8WJuGIMH5XookOVJhfjDgGBmFKqWn2Ynn6BfhSe0KC6BKRLeb42Yz/hVhTdsxNcEACy71EAANSJmAABodd2ZIBCUgwAXa0KRkUk7z9GNMEBhgSZQIAiNmSbK1M0AAAVepIgZsrTSABAFj2kqeZQIbXn5MysYnJmw/IGSVzfEyQwAPd1Wbbmo/Sl1KAnA7lwKKXThDBA1g28EAEXBJaKHzRqQmTohAQRUCjQjEACgRVRjpppQncKuecBhRAgFAEQNBdBAUcwOYsfFQKwQEMKHBAAbFKeWv/tKWemqqqiaLZJwUWkHjjZwYIsl2xCog5a3agdKcrpRNA8EAC09I6JwV0yIYAAMoycCq+D+AyTUrWNCABtX4CUAB2ImCZgAJlctutoRdeQAGKHVQQLn7v1RSsGnYogN68QhkAQAITvGuABKQK5UCdR+4aAR0o/zEBAXEK9eewaeQKAQWZdHdzywQgIPGqQ7l0YoocfNBBkn65ClO5xqo3aXIPCKPwBKhISmm0ldqpQI1zjioBA8IWgC/KaaxUZ6T6/hzpaQYogGXRRy9JMUseeGBjx+QuOtSsWN+CS3EUdL2rv2HPYl+fEyjgSJgIRCtm2+293UB7mOAb62kR2O0n/wN5T8wqS97qiKhMVDM6MspCNaCsyqMOy2adxEW8aa8IHJC4IKfhLKaUgKa8edxAQyzUpFgaEEHpmO7tm9RH1l0Ao2JO2oCtp0YeK5zLmcpu93cq2yfLyvcC+6fzTmo0BXXSGeuolTegRqDdQ39k6q1R/9ItUTpAA5YzpmhUCYAMMJZsCGBAoRygZS1pxGl4USU28U5Lstlee26BAT8hAgISMNjNcKW//UmvSeMCEuToAx8ksTBpourdhzoVpBZ6h4a4KVIJX3i6lSDoQJ7xn4tyAbUdyuiEkFuMuAAXRCP+LWktwRAGOFCBDnigiIlZnRO3WKClrWgAT/ORFrdYnv8cQagCFUiJA8jGMfDUBFrDwcDzUpIen6QnVXVkSQQc0CLnoWpqlVJJBOboPO9I4FUGQFxN0ANI1PlxWyvR3V28xb++CJEliTQAAYpznDUeRwIYSORxfEeBA3CSOMZhQHE4+UkMwJGUxblOcpQznFJexzjIKSVycMmAT5pSOMQpjp+OwwA5rtJ3iSTOlYyDSlOi5zioHKYzE1mc523ST7s8GwOEc8xcjlKSP9lR/8b4kkwah14MSM91fHccKilHONhppzNVqckrka46ydnjOsGUHO0oC5oSoJfv0gnM66iSO6o05QEIgB7k9NKWVDrAylIZnEFCi6HQSugm76nKXtL/U5XV6U46O9rLhS4UmsrapHEgGc4SoYYxbXSOxySQHlSmkwKjxCm01sNKUzIAPSsTDi4P2cw1Qut5n5zlcnJHTdqAFKWmPKRxRunNauryAA4AajWT082sMjOqyFSoKZOp0OWokqq+pOken4cc58UlNs7jY6ig2BxyxoU2LdrjYtgYE3C+hKay2ZLH+hrJnEiAj+Bk5BLp6ieVKrSXzMSiXS75VjJaKkIWEpVBt6mdKwXyiExk3R53Msg5WjZNmZ0NHemYx5jqpiYJPc9sLJqe4ahntioJDk23VKM6MnKQtCHkeoKbkuetZ5CsXcxwn/dbNgJVd79NiXFY+9yapkSi/3rN6myIex6sZhU9XDIubX3rV6DU5zKuXQ1sz3ZMYor1p+tEDnMOeVYxQYuTCc3o8zp635LGkqTQXCd6SrpOAj80lj49m4IV7NN/9jKRBb7pWX0XAf7e0pUMWOM6ZyNgsWqTlHIR5xNlShOPjhQ5q0xoP8NkHMRK9JAMHd1PnZmc7DwzOD6FL3KoVOFbblKlxKnwJimA0SspqzrBMXF9GSqcleHUoMXZJBylNOPzcHahB0amO7OKnXQeR6hePmSIKQmuBIkxhTJhZiaT40flfFfB6QmsA9QJOpraVj3JWa1aKyzRleG5lkitUm1pamXuEFq2fsbzT1e2R+36OXfABf8sbdm0Zz/PNrh1ZDSbb4zn33iLr0G0q2BU65LW5kR3knXJcCR7R5iO+lWi6aLFNpSBC6R6sqI+7dEgtCEqbujWnkazrvUnTjOfObTDhh6EfgjEY7sx2SUUcWlyDW0zSTvW1K62GSs5bWFrm1vSbnZ6QfPt0l071N4ut7XR5IBZc8jWziaxusHtLQ6k6AIrAvaY0z1vHEFojXQdt2X6TW8k2uaHi5U3wZV07oQrfOEwuk+rFkTxils8K+K5uMY3znH0zqlH8e64yEee6/ZsTOAkT7nK1aK0NGLMQyFfucxnThalYewCTtP3W2nO856H5SV9G7HPh070qQzJ4KorutL/l+6UjDP96VB3KWHcE/WqQ50+fg5lYAMOWqt7fej0wfGH/TsoEH397D2nT48vmlFVXtbs71mZzuxTF/QQEC+SvjtS7E53tRQSp30vivMKORhNCdY1C0qgUArQnUPK5rBCIQ6uxExAt5rFAcm6GcoGGfnKRwCEhEaPzrZkFgZsLli0cbwDHC+qXCSHTZ4P/M8hJ/G65udguDCW6bWUiwYYwPQQYLHpbxGBRiiw5qlI4E9TcU56fT4BBfikKjTZB9uRZVrYMVYuuJMLLTkCAtwUIAR++orj1/xQty9AAnSB/WQtdPzGCug2E8DQV5CuAHr/eR94MXxHnG1yBEABBpMd/7iyfg1AZMdDFgczfNPCQL+0MBDgAJy1HSFkMMiSf7PXEuGCcDEHGryQEvDHXgazPQ3gAALEdgaQCgGIf2UBNClFALdwHNuze4EyJaZHZDBIAetnFgIkKtuDKwtlMPA3JtlxOMUnOxdoFkBHATXiNw63GgGVElqSQNxhfKaUfMREU9xBfyxYc2EyJsiRCsTRCAPkCAN0UBTgUbpgfWMRHBZEfelEhqZkf+ylhcWnCxgIFkpzAQ6wIh/AIh04LkhyG0chfwfIFptCiIOIG7ggO3hxKbXxKEURUDmohC6xIRfgAShycrZHdMEhNBqnScOzcdAie3r4KlzXdWi3iin3Ev/ihm6sGIsj53S3l06gJkiVglzAckfO9TwMMgE1wkiBVXbnsRs/BWqV8nd+BIzfYmrFhVe3GFcuY1q4aBTHUV6yBXtiBjnqEUqbIoyoc2kdtF035DwdhHTjlB//RVI/lYYYdVArk1A/tXa/t1nbFI8H9VjXMSbAJGVGZhTUVGBG9mTIsVESRVK+k1H4uFlYtU6OdVHO41kR9lNGgWD2qE4MNYEQph2DtE8RtlAmKGXyuE0D5WX+OGTchm23h2J2xkw6NVFs5jxq5kcDNlUQFpFcNUijdEhjJUpn5Yu4wUkvxknd1VD59F1tdR5+5kvOgzggdUrfVGFIpU3GAYpD8Un/ysFJqYdVzHRYTXlnpVVhNnk2OMVQUzVLiFMcWYVgccQ/HIhyPJeIgpeHSJFVZ8FHRwGUTaGXYyGXREF4TQGY/7YBhOkALKWKoWiV4ZFDdXkWsxEajMmYfjkWeMUaUASZXKE0HNCHHDAAgAiXbBFkXDUbcjJkNIlc0KSTyOFVDtRPtSVdyBWbtoVTiokbzBRkOMVHn6hpeSZKpVUcBrB6jTccD8V5pXVpMHkedBl5tERhVSIcyml3tEFjwcRcy5FMZOlkfhRczFWVwulxLIEivvaZVKeOByWP3GGCxMFZAXWQ1mGP22RW2eGQg0R/NEVgSWZSSfF7wWFPJIlTxESS/2TSn/ZkHfpJiRFWT6RDTAUKkUnhU/MJkcmkHb0UJvVkHf55j0QWodhRY4sGYEZ2TaGBijq3b0yEZ90IOsN1LIO2XXgGjL+VR0AVSt1YXR5HG+uxKYMXV9dZU155XKzlopg2R3ZHo3w3ouexRnbnXMP1jIymlNIJo9QlpKLiVkJamz3EQzqEmLLYpRVHi8hWaqRHaqjGRiWzKV8CTnilpZVUR2e6WmjKQqq1pdSoEkIzmdxWJmxSJnn0i8BYIx/ijHPKpugodKvRX/DZWcqiST5lT0FlUOt5HboEZfD5Sx4lokjxe22XqJ51MwY1n4cVolG2UB2ZURcloCQVqVg6FP/6yKnC0VgG9WOrt1EedV8SuKkZGquxhKm1Nz0AklZKJVbOpEs0FVWiMhxitTJcOUpchRz9lJW9hFz7uUrD0ZXCCkrV+U041U9wJJU2ZVE0RmMKBlxKMVXV5KzCKlHESk1iUlrx1VTH1Kw6Ga3Mynng6ashYpmWMoh9F4lE8kKmiKeWWReEOFeKuJgFW7AB+xSmaEOQuJiPcxsRCxhNh35eerFfOnEAopO41EG1xZ80SZPqmhyeFJZhiWizxJ0UxmhNKXvKuUp5Uq3YlU+/SVRxtGml5Vbp4VU3y1Q6+Ux0qZqm1B65M485+0x9Nl3bepqx+bK/NV12Z3e+g7FZsan/FHlfpZQd/aW1IzlIucpZaXiq9LRM9fRLKAmQ7BhWZkl/j+WfGaqpC7UdHcpnBZpIniV/0GJjSJFjslRKVyKBRnZQ/th2pYqh1hG2nBWtRgYmHXU4DUu1DHtpKEs2ioVbs1Wn0RmWEzV4ogdUyslalUkxyBVnimWlz7hdlUtHUTtIXnVcocRIcfWMePkcg4eyZVK5eeRHLQFc28my0ilHdXRotwW5xKsVj1u8F4uns+lCSYOl/dqvWycVeJpoc2UfoQtDLiR71xu54bG8B9sezsspj2kUc4a8X0FVEJYS8BRVbsdeOdaUj1Wqo9RRyPq+UEFNznq1DeZTA/ZYaem//7Y0v2X1SQkVFQlGTWwCT+ylSibov+nEZwoVkf+lULiUY8drvlHBVfKIKpB1S1UZX8RBJfW4Sxx7S7VqqvF5v/3EX9gUqbe5UcR5ABgGWS1pUvJoqvcVFakkj8EJWSbFZlKGYtxRHT/5swU2do26qhhcFZEYp/w6R9h7GVF8Q1PhGIs4FHEGvS4LQ7bBGFZBd3hajBecFwK7xDUnFUq8IID6iFExvmZcFjuKZ+WbaEGWjE76XKtWx3HMoh9bU312jrvBuzUlo0DFTHwEu1GrHmIGnHu8pzVlXCyrxHu8o7Dnx5xnpUD1XMbZVnsspIfko3H2xlBhwxmqJf25WdyBZf/blKvZoVOrHLfQKbdFdi6ryqhdZmTOV6D+xLgZpcu4sEeWeh30t6DDvElEvB3KsreKWrdtV7fY0aiofE1fZrhNJstC9p5pLMqC56Nul2eoa3de+bO7dZqk+aRhKSqlRVRhyXq7EVxfFpy1FJwxiZo0m8k62Xj3rGmkmc/V6mf7SZrsdR5iVluFfLnPpMj5RGl0DFzbepwmiyraPBXba3FlTHHZHNEAcqcbh6Ycp9EY3XERECavd3Fp+FPsXHG6tWofzXELfNILUo8gpXFt59IrTXFzQtK0l7E5XdM83dM+/dNAHYt04ZhuQdTmFdQ/h3FjrNQY55hMjdRt8a958Rz/liixU70bTj3FmGlDUN0VtmFQIZuGyDqvgIWXFe3Vp6FNOZt6Jo2u8pWIS93UJghS0smfovlJfGTWcd3VDFsrC9MI7McLkwOAt0BkgVTVQNN7xeJ7ZngLjtCICPy9YmEbxQKD64d/CZQKBkh/2+MAASiJfG28RLu0xrVLMMlowIhDk20b4PykZ5myxCGnWT14tvXJpq1mq/awob0Vez2iVY0Vvf3FT73bSl3ULTjUx23cxF3cf2HUze3cgrHc0j3d1F3d1n3d2J3d2r3d3N3d3v3d4B3eVZFIizG1SbF6I42I8mUcS1GsFy0WcpdIj5tPoyjeTfGBiXMstgF5oiJA/94ce0qYeUQUyoSXHgYjaUKzR2fBC6LCeKJSG744G64nJna5p4Bs30SBewxEfb4Hgx2u2cSkgs/XhX25C+P3ec9SgcgRfNEnHKpQHdXHg8miC2DSCDXO2NWXUX7QS+X33tx9MOv3LCA0fjJoenIkO5yVgo6IKy3YB1RoOAazUOunLANoeprkCERoFguYCrzAf8cxhDZoHSGNKwbA5BhOFIoXL8q3SQvz12czfrmQTuAnHGY+FpiXUgbYS4BtOMhig4wNgwEFO2SheGWufNcxfhAY0tnBtneoSiR+5o0lhSZIfJx9hduzk78HJgy0nJn5hfS0fiG8fjculgF4qcGn5f/DAia/Z2OVzguyg+k/ddmcDumgGDYT7YOOENzGKzR6yiZ1kQsghBd3ausXfpWareuQzhq509HytdHTlezQHu1XzXHIXnjSrhXXCBOK5c12CrqQJK1fopS1kcUrgYGlNFqoVlPhdcl2GliJBahrFEnSKKV6NLtXqa4vQUjcTkfK5YzgKEm16+76IZg+Hcxx246/HKsrHJ9E7J4TaJYO2ahXQoTDIVD2BJDBnLh+W5BJjpAlbZJuO1A/xrdDnB2aJLgxVhQZbx0YKWT32Mxea8yJC49JRpK97Du/3J4HX+2Qi1IN5ZLHAaDzPJPSScOrl2EVlZpDVUq7Naq1FB67hF3/RFnHzrpHTQm7K9PA14hKRCZRULn17fhftmWNY41KhBb0tzlnvolnHQn0pDMlSoWWPElUDfb0Qc3zWN3ODJvGW2x0sseXS3HrhEEVsle+TefjSB3KBKvakVlzPt6wZ90Vgm8oW93dZr/15iMcXqVUGFatcLZSGNDBDQXQUnVYKZtMoeFMcCZRowO01Wpl2URPmSQlCAag2/rJavVJMtmwWLlT7O3ZLdnPJS2zi8be/Hk26YFMzIQBVWmTs9/VChXECzWdkdpLmwTTiXq10j+P2XGfWRjx03o2BrlJcrTDG2Vo2W9SchS4Cum4oySSDrq3bEdSyR9MPqaFqzyR3OGO/2JlaFfSvyDAMJJ4MMeUqivbui8cyzNd2y2VG3nkGAYGM4n8fg7HpBiJUIq/yKSp+00NyeIVC6NEd9Qdt1lsdn8SsZEprqKrE994q5tTU0QntyjxOq3SNlpW1c9NoeEhYqLiImOj4yNkpOQkZWVUDibmJVEKBdMQGJeD5lVY5pBa5qeUTCYmUN7nEGbqZU4n4ZvrmWvuUatrMFEe2HBYaEqdK2pTEIbnMZflNHWixAF2yYmJyEnStomJgwRBdgS2CQX6tnZ4OIk3jMEBfLc2AwGDlXb+iEM7iQMElmRjd88cNysw6HGzF06EhAnkGgocdwLixQPzuBV0WAIeimoiR//OkGBSwhKUBq5dw8YE2x6YqM6hM3Bu3MmV9FIeIEJzSQQhL+adQ2lSZ0t6GGjqPDBqT1KUPYtOhUlQYwSWSxS+ODkVZVaG2HbA3Chh6RJwOnHSQ0pEa0ugJOfSPSStLqK7eO3u7et3rt6/KwKruGWJMA3EnQQzbowo60kGxPaMSAmW4A6TRy4DtQnNZltP51CZJIiYglQSUHIYnZoVaFFPKGXb7MwkTWnRGh2kJAjFBU9snc4ZYAC0NE8zZ1b6tA3N95NraEtfU+z4ugyBIvJBEXhAXYJyJwgkuGgPZT4C6tcToNBtvcbyGtVjUy/ZRXET9Jvgyxp+XXnb2RPBNuz/kbdEeusVl89K8jFQ3m8tZGPfS+UZYF849GnXT1oChceeewKlh9J/Bjhon3XYqYgDD1bwQUso0DRhTCZ93KHSE1YYY0wcLkwhBig6pLLGjMF4ogQTWTkBBRVF/viCkDvc1sMzPbwSCo0wKmHGkqPsCEaTK4o5JpllmnnmI39ckoJKy/QizTJr/gFnFym+cASdSewRYyev3GLKn0YWloRhNrAiZ5un1BjoKbbMuZgPdqJZZkPnSEZBAuTc40BD26VVIIIFiWeSPcbdUBxE5ES0TqUElpDPd914x6l5GVmqXUg2ZNOTCUkQEJB5/7AjkE2lhkrRCMDig8SkzaoQ1jpB/xl3TWWUbZPVQKj2BBZKJ5AQ0K4mREiDTeBisxSvqWJrQrffvXMUZCOgwyo6hZC6zg7ThqNkOWOR8MNHx1nKkjv4Ontwn4qasgIQQawZBZR3KSxpxKTE+QYScIYBMQ6DCmqIJowWmgTHhil2izMhj4wwy5Awi+bKZMbcMs3MweaTnkDtxIMPKoG1UkQEqtQcFD4Vp8RUJ8Nbm02Z+XQNJ8NspSQRToV4s00YMG3SkTtx1YLNteG8khlTJTHlW02bJJFxnTV9ZNVHQj0uzY091M92K92Dzzx4w/red6S+yp179k1b6tcMX4T3RARyVMKFtUpuAKedyoea4egBvlB94//pp7dDBMyTADr9jueN4Kcb5wB8xmnXTeJ1/3UEb46LpooSR9hWDFBN7DGM2DNlLbZnFaekD2pezPhEUEYvEeUeEvnUYlBMS900JxEzN8LtUT4x49ReNKfn20aj9T1sNsk+pgNCnTnzmLGvP/8iO3BcJhkUM2a//vT7L0MEfpUVM6EqK/3ri6pQ8r8FWmMbZygTqk5AtxVx5IEMvOANSGGmkL1Pgxj8IAhDKMIRkrCEJqyEkVKoQg9SY4UuDMZIXihD+J1QTAeUg0homMEYNkKHNbyOXihGGB+mSWKJ8REPB2WXG/5wL9LoRvooUA6h3ctFfcohF8gxkMtgzlLQqsX//Vr4Bnxsq2kXIpVRRmAFZhGxiYKRxgEgEMcEJECOB2hAAhqgHjwyQI9S9AMT8xIGCDxIjxBogInqGJ4GNAAfENDJYnKYAgI0Eo8JKACB8KhHAkAgH4SU4sLcKLPhJM8zqNlKaWpTskAu0Q7WK9rUcPTAPFVDGltaSc7eMrTVXFGUY2IlC9rYQ2AOJomLEKYv8TLDGWJxmS6MoTOfmUwyOaOa1rxmNeuCzW1y030k6SY4HTbNcZKznOY8JzrTqc51srOd7nwnPOMpz3nSs572vCc+86nPffKzn/78J0DLSYhxeHMoTcpFQBP6iOJA5SQscehOaIUOAhFToRZNRltMXvIOwNFEHapJy8suKlJD/OIznZBApEBBKPv5YKQufSlMYyrTmdK0pja9KU5zqtOd8rSnPv0pUIMq1KEStahGPSpSk6rUpTK1qU59KlSjKtWpUrWqVr0qVrOq1a1iJwQAOw==) no-repeat;  background-size: cover; border: 1px solid #E3E3E3; border-radius: 1em; overflow: hidden;"></div></div>',
								'description' => 'Sidebar goes off page on smaller devices, and a button appears to toggle the sidebar in from the right hand side.   Also has a fixed navigation bar at the top, and three default callouts. ',
								'install' => 'a:9:{i:0;a:1:{s:7:"Webpage";a:3:{s:4:"type";s:8:"template";s:4:"name";s:10:"toggle.ctp";s:7:"content";s:3265:"<!DOCTYPE html><html lang="en">	<head>		<meta charset="utf-8">		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">		<meta name="viewport" content="width=device-width, initial-scale=1.0">		<link href="/favicon.ico" type="image/x-icon" rel="icon" /><link href="/favicon.ico" type="image/x-icon" rel="shortcut icon" />
								<title>Export toggle.ctp</title>		<!-- Bootstrap core CSS -->		<link href="/css/system.css" rel="stylesheet" />		<link href="/css/twitter-bootstrap.3/bootstrap.min.css" rel="stylesheet">		<link href="/css/twitter-bootstrap.3/bootstrap.custom.css" rel="stylesheet" />		<link rel="stylesheet" type="text/css" href="/theme/Default/css/toggle-custom.css" media="all" />		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->		<!--[if lt IE 9]>		<script src="/js/twitter-bootstrap.3/html5shiv.js"></script>		<script src="/js/twitter-bootstrap.3/respond.min.js"></script>		<![endif]-->		<script src="http://code.jquery.com/jquery-latest.js"></script>		<script src="/js/twitter-bootstrap.3/bootstrap.min.js"></script>		<script src="/js/twitter-bootstrap.3/bootstrap.custom.js"></script>		<script src="/js/system.js"></script>				<script type="text/javascript" src="/theme/Default/js/toggle-custom.js"></script>			</head>	<body class="webpages authorized export userRole1" id="webpages_export_3" lang="en">		<!--[if lt IE 7]><p class="chromeframe">You are using an outdated browser. <a href="http://browsehappy.com/">Upgrade your browser today</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to better experience this site.</p><![endif]-->		<div class="navbar navbar-fixed-top navbar-inverse" role="navigation">			<div class="container">				<div class="navbar-header">					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">						<span class="icon-bar"></span>						<span class="icon-bar"></span>						<span class="icon-bar"></span>					</button>					<a class="navbar-brand" href="/">Demo</a>				</div>				<div class="collapse navbar-collapse">					{menu: main-menu class="nav navbar-nav",var=nothing}				</div><!-- /.nav-collapse -->			</div><!-- /.container -->		</div><!-- /.navbar -->		<div class="container">			<div class="row row-offcanvas row-offcanvas-right">				<div class="col-xs-12 col-sm-9">					<p class="pull-right visible-xs">						<button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">							Toggle nav						</button>					</p>					{helper: flash_for_layout}					{helper: flash_auth_for_layout}										{helper: content_for_layout}											<div class="row">						<div class="col-6 col-sm-6 col-lg-4">							{page: toggle-callout-one}						</div><!--/span-->						<div class="col-6 col-sm-6 col-lg-4">							{page: toggle-callout-two}						</div><!--/span-->						<div class="col-6 col-sm-6 col-lg-4">							{page: toggle-callout-three}						</div><!--/span-->					</div><!--/row-->				</div><!--/span-->				<div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar" role="navigation">					<div class="well sidebar-nav">						{page: toggle-sidebar}					</div><!--/.well -->				</div><!--/span-->			</div><!--/row-->			<hr>			<footer class="">				<div class="col-lg-6">					{page: toggle-footer-left}				</div>				<div class="col-lg-6 text-right">					{page: toggle-footer-right}				</div>			</footer>					</div><!--/.container-->	</body></html>";}}i:1;a:1:{s:7:"Webpage";a:3:{s:4:"type";s:7:"element";s:4:"name";s:18:"toggle-callout-one";s:7:"content";s:321:"<h2>Heading</h2><p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.</p><p><a class="btn btn-default" href="#">View details &raquo;</a></p>";}}i:2;a:1:{s:7:"Webpage";a:3:{s:4:"type";s:7:"element";s:4:"name";s:18:"toggle-callout-two";s:7:"content";s:321:"<h2>Heading</h2><p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.</p><p><a class="btn btn-default" href="#">View details &raquo;</a></p>";}}i:3;a:1:{s:7:"Webpage";a:3:{s:4:"type";s:7:"element";s:4:"name";s:20:"toggle-callout-three";s:7:"content";s:321:"<h2>Heading</h2><p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.</p><p><a class="btn btn-default" href="#">View details &raquo;</a></p>";}}i:4;a:1:{s:7:"Webpage";a:3:{s:4:"type";s:7:"element";s:4:"name";s:14:"toggle-sidebar";s:7:"content";s:434:"<h4>EXAMPLE SIDEBAR</h4> <blockquote> <p>A great product from a great store! Glad I was able to purchase and get it so easily.</p> <small>Thomas Edison <cite title="Source Title">Wardenclyffe Tower</cite></small></blockquote> <blockquote> <p>It feels great to get customer service and a great product. Can&#39;t wait to come back for more.</p> <small>Galileo Galilei <cite title="Source Title">Vatican City</cite></small></blockquote>";}}i:5;a:1:{s:7:"Webpage";a:3:{s:4:"type";s:7:"element";s:4:"name";s:18:"toggle-footer-left";s:7:"content";s:230:"<p>&copy; 2013 <a href="/">Demo</a>. All Rights Reserved.<br><a href="http://buildrr.com" target="_blank" title="Create your own online store with buildrr.com hosted ecommerce">Ecommerce Software</a> by buildrr</p>";}}i:6;a:1:{s:7:"Webpage";a:3:{s:4:"type";s:7:"element";s:4:"name";s:19:"toggle-footer-right";s:7:"content";s:59550:"<p class="socialmedia"><a href="http://www.youtube.com" target="_blank"><img height="48" src="data:image/png;base64,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" width="48" /></a> <a href="http://www.twitter.com" target="_blank"><img height="48" src="data:image/png;base64,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" width="48" /></a> <a href="http://www.facebook.com" target="_blank"><img height="48" src="data:image/png;base64,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" width="48" /></a></p>";}}i:7;a:1:{s:10:"WebpageCss";a:4:{s:4:"type";s:3:"all";s:4:"name";s:17:"toggle-custom.css";s:7:"content";s:758:"/* * Style twaks * -------------------------------------------------- */body {	padding-top: 70px;}footer {	padding-left: 15px;	padding-right: 15px;}/* * Off Canvas * -------------------------------------------------- */@media screen and (max-width: 768px) {	.row-offcanvas {		position: relative;		-webkit-transition: all 0.25s ease-out;		-moz-transition: all 0.25s ease-out;		transition: all 0.25s ease-out;	}	.row-offcanvas-right	.sidebar-offcanvas {		right: -50%; /* 6 columns */	}	.row-offcanvas-left	.sidebar-offcanvas {		left: -50%; /* 6 columns */	}	.row-offcanvas-right.active {		right: 50%; /* 6 columns */	}	.row-offcanvas-left.active {		left: 50%; /* 6 columns */	}	.sidebar-offcanvas {		position: absolute;		top: 0;		width: 50%; /* 6 columns */	}}";s:5:"order";i:0;}}i:8;a:1:{s:9:"WebpageJs";a:3:{s:4:"name";s:16:"toggle-custom.js";s:7:"content";s:133:"$(document).ready(function() {  $("[data-toggle=offcanvas]").click(function() {    $(".row-offcanvas").toggleClass("active");  });});";s:5:"order";i:0;}}}'
							)
						)
					);
		
break;					
		$Template = ClassRegistry::init('Template');
		$template = $Template->find('first', array('conditions' => array('Template.id' => $id)));
		$data = unserialize($template['Template']['install']);
		App::uses('Webpage', 'Webpages.Model');
		$Webpage = new Webpage;
		try {
			$Webpage->installTemplate($data, array('type' => 'default'));
			$this->Session->setFlash(__('Template installed'));
			$this->redirect(array('controller' => 'install', 'action' => 'build'));
        } catch (Exception $e) {
			$this->Session->setFlash(__('%s, please try again. <br /> ', $e->getMessage()));
			$this->redirect(array('controller' => 'install', 'action' => 'build'));
        }
 	}
	
/**
 * Menu method
 * Create a new menu for a user specific case for menu creation during build
 * 
 */
 	public function menu() {
		App::uses('UserRole', 'Users.Model');
		$UserRole = new UserRole;
		$userRoles = $UserRole->find('list');
		
		$text = __('%s Dashboard', Inflector::humanize($userRoles[$this->request->data['WebpageMenu']['user_role_id']]));
 		$this->request->data['WebpageMenu']['name'] = $text;
 		$this->request->data['WebpageMenu']['parent_id'] = null;
 		$this->request->data['WebpageMenu']['item_text'] = $text;		
		
		App::uses('WebpageMenu', 'Webpages.Model');
		$WebpageMenu = new WebpageMenu;
		$WebpageMenu->create();
		if ($WebpageMenu->save($this->request->data)) {
			$this->Session->setFlash(__('New flow started'));
			$this->redirect(array('controller' => 'install', 'action' => 'build'));
		} else {
			$this->Session->setFlash(__('Save failure. Please, try again.'));
			$this->redirect(array('controller' => 'install', 'action' => 'build'));
		}
 	}

}
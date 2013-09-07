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
		
		$Template = ClassRegistry::init('Template');
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
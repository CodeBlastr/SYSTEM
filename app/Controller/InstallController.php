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
        $this->options['siteName'] = Inflector::camelize(Inflector::underscore(str_replace(' ', '', $this->request->data['Install']['site_name'])));
        if (strpos($this->request->data['Install']['site_domain'], ',')) {
            // comma separated domain handler
            $this->siteDomains = array_map('trim', explode(',', $this->request->data['Install']['site_domain']));
            $this->options['siteDomain'] = $this->siteDomains[0];
        } else {
            $this->options['siteDomain'] = $this->request->data['Install']['site_domain'] == 'mydomain.com' ? '' : $this->request->data['Install']['site_domain'];
        }

        $this->options['key'] = !empty($this->request->data['Install']['key']) ? $this->request->data['Install']['key'] : null;

        $this->config['datasource'] = 'Database/Mysql';
        $this->config['host'] = $data['Database']['host'];
        $this->config['login'] = $data['Database']['username'];
        $this->config['password'] = $data['Database']['password'];
        $this->config['database'] = $data['Database']['name'];
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
        if (!empty($this->request->data)) {
            // move everything here down to its own function
            $this->_handleInputVars($this->request->data);

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
            $this->message[] = __(' ( could not load database schema ) ');
            $this->_redirect($this->referer());
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
                        $this->err($error);
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
                $error = $e->getMessage();
                throw new Exception($error);
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
    	if (Configure::read('Install') === true) {
    		return true;
    	} 
    	if ((defined('SITE_DIR') || Configure::read('Install') === false) && $userRoleId != 1) {
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

        $dataStrings[] = "INSERT INTO `aliases` (`id`, `plugin`, `controller`, `action`, `value`, `name`, `creator_id`, `modifier_id`, `created`, `modified`) VALUES
('50dfa6c9-e59c-3306-969c-031c45a3a949', 'webpages', 'webpages', 'view', '1', 'home', '1', '1', '" . date('Y-m-d h:i:s') . "', '" . date('Y-m-d h:i:s') . "'),
('50dfa6c9-e59c-4406-969c-031c45a3a949', 'webpages', 'webpages', 'view', '6', 'error', '1', '1', '" . date('Y-m-d h:i:s') . "', '" . date('Y-m-d h:i:s') . "'),
('50dfa7e4-2e18-47da-b770-031c45a3a949', 'webpages', 'webpages', 'view', '7', 'about', '1', '1', '" . date('Y-m-d h:i:s') . "', '" . date('Y-m-d h:i:s') . "'),
('50e132bc-7a20-4102-9b84-102245a3a949', 'webpages', 'webpages', 'view', '11', 'contact', '1', '1', '" . date('Y-m-d h:i:s') . "', '" . date('Y-m-d h:i:s') . "');";

        $dataStrings[] = "INSERT INTO `aros` (`id`, `parent_id`, `model`, `foreign_key`, `alias`, `lft`, `rght`) VALUES (1, NULL, 'UserRole', 1, NULL, 1, 4), (2, NULL, 'UserRole', 2, NULL, 5, 6), (3, NULL, 'UserRole', 3, NULL, 7, 8), (6, 1, 'User', 1, NULL, 2, 3), (5, NULL, 'UserRole', 5, NULL, 9, 10);";

        $dataStrings[] = "INSERT INTO `contacts` (`id`, `name`, `user_id`, `is_company`, `created`, `modified`) VALUES
('1', 'Administrator', 1, 0, '" . date('Y-m-d h:i:s') . "', '" . date('Y-m-d h:i:s') . "');";

        $dataStrings[] = "INSERT INTO `settings` (`id`, `type`, `name`, `value`, `description`, `plugin`, `model`, `created`, `modified`) VALUES
('50dd24cc-2c50-50c0-a96b-4cf745a3a949', 'System', 'GUESTS_USER_ROLE_ID', '5', '', NULL, NULL, '" . date('Y-m-d h:i:s') . "', '" . date('Y-m-d h:i:s') . "'),
('50dd24cc-2c50-51c0-a96b-4cf745a3a949', 'System', 'LOAD_PLUGINS', '" . $installedPlugins . "', '', NULL, NULL, '" . date('Y-m-d h:i:s') . "', '" . date('Y-m-d h:i:s') . "'),
('50dd24cc-2c50-52c0-a96b-4cf745a3a949', 'System', 'SITE_NAME', '" . $options['siteName'] . "', '', NULL, NULL, '" . date('Y-m-d h:i:s') . "', '" . date('Y-m-d h:i:s') . "'),
('50dd24cc-2c50-49c0-a96b-4cf745a3a949', 'App', 'TEMPLATES', 'template[3] = \"eJw9jUsKgDAMRO+SE9hWF063btx6g4IRChWln5V4dxsrhsA8JhPGoceVoDpQ5v0MLvO8kq0OyIiOIJ8m3lwJ+fOVaA8qMSRBDarTsiVxXI7A72GoIScFHt3/6qEaa2H9V3mYxgPZu+4DaXgqeA==\"\n', '', NULL, NULL, '" . date('Y-m-d h:i:s') . "', '" . date('Y-m-d h:i:s') . "'),
('50e08ff5-d88c-42d3-9c99-726745a3a949', 'System', 'SMTP', 'smtp = \"K7qTTLH17Ja5XTUiHLtnOyYqkJQxiT+L/xgkhZUspI5RlOrwyrRTNUo29SosNwiFlCuTIJXieHrExT6g313X4N6X9TFSNFHyNxAoK5DHZcQ8ivIoaYOKOb6LEofp5OndTzUzTNYoKjN42cds0nrqjD41i4p46sdSi/TslLtFGCRd9DMrLjWUiyHKLIjrVU2ClTe6qV2J46nZ9x4bJk7yFDEqKIieeKEsiOs1IpaEPfU=\"', 'Defines email configuration settings so that sending email is possible. Please note that these values will be encrypted during entry, and cannot be retrieved.\r\n\r\nExample value : \r\nsmtpUsername = xyz@example.com\r\nsmtpPassword = \"XXXXXXX\"\r\nsmtpHost = smtp.example.com\r\nsmtpPort = XXX\r\nfrom = myemail@example.com\r\nfromName = \"My Name\"', NULL, NULL, '" . date('Y-m-d h:i:s') . "', '" . date('Y-m-d h:i:s') . "');";

        $dataStrings[] = "INSERT INTO `users` (`id`, `full_name`, `first_name`, `last_name`, `username`, `password`, `email`, `view_prefix`, `user_role_id`, `created`, `modified`) VALUES
('1', '" . $this->options['siteName'] . "', '" . $this->options['first_name'] . "', '" . $this->options['last_name'] . "', '" . $this->options['username'] . "', '" . $this->options['password'] . "', 'admin@example.com', 'admin', 1, '" . date('Y-m-d h:i:s') . "', '" . date('Y-m-d h:i:s') . "');";

        $dataStrings[] = "INSERT INTO `user_roles` (`id`, `parent_id`, `name`, `lft`, `rght`, `view_prefix`, `is_system`, `created`, `modified`) VALUES (1, NULL, 'admin', 1, 2, 'admin', 0, '0000-00-00 00:00:00', '2011-12-15 22:55:24'), (2, NULL, 'managers', 3, 4, '', 0, '0000-00-00 00:00:00', '2011-12-15 22:55:41'), (3, NULL, 'users', 5, 6, '', 0, '0000-00-00 00:00:00', '2011-12-15 22:55:50'), (5, NULL, 'guests', 7, 8, '', 0, '0000-00-00 00:00:00', '2011-12-15 22:56:05');";

        $dataStrings[] = "INSERT INTO `webpages` (`id`, `parent_id`, `name`, `lft`, `rght`, `title`, `content`, `start_date`, `end_date`, `published`, `keywords`, `description`, `type`, `is_default`, `template_urls`, `user_roles`, `creator_id`, `modifier_id`, `created`, `modified`) VALUES
(1, 0, 'Homepage', 1, 2, '', '<div class=\"row-fluid\"><h3>THREE COLUMN LIST</h3><ul class=\"thumbnails\"><li class=\"span4\"><a class=\"thumbnail\" data-cke-saved-href=\"#\" href=\"#\"><img alt=\"empty\" data-cke-saved-src=\"/img/empty.png\" src=\"/img/empty.png\"> </a></li><li class=\"span4\"><a class=\"thumbnail\" data-cke-saved-href=\"#\" href=\"#\"><img alt=\"empty\" data-cke-saved-src=\"/img/empty.png\" src=\"/img/empty.png\"> </a></li><li class=\"span4\"><a class=\"thumbnail\" data-cke-saved-href=\"#\" href=\"#\"><img alt=\"empty\" data-cke-saved-src=\"/img/empty.png\" src=\"/img/empty.png\"> </a></li></ul></div><div class=\"row-fluid\"><h4>FOUR COLUMN LIST</h4><ul class=\"thumbnails\"><li class=\"span3\"><a data-cke-saved-href=\"#\" href=\"#\"><img alt=\"empty\" class=\"img-circle\" data-cke-saved-src=\"/img/empty.png\" src=\"/img/empty.png\"> </a></li><li class=\"span3\"><a data-cke-saved-href=\"#\" href=\"#\"><img alt=\"empty\" class=\"img-circle\" data-cke-saved-src=\"/img/empty.png\" src=\"/img/empty.png\"> </a></li><li class=\"span3\"><a data-cke-saved-href=\"#\" href=\"#\"><img alt=\"empty\" class=\"img-circle\" data-cke-saved-src=\"/img/empty.png\" src=\"/img/empty.png\"> </a></li><li class=\"span3\"><a data-cke-saved-href=\"#\" href=\"#\"><img alt=\"empty\" class=\"img-circle\" data-cke-saved-src=\"/img/empty.png\" src=\"/img/empty.png\"> </a></li></ul></div>', NULL, NULL, NULL, '', '', 'content', NULL, NULL, NULL, NULL, '1', '0000-00-00 00:00:00', '2012-12-29 17:38:58'),
(3, 0, 'initial-template.ctp', 3, 4, NULL, '<!DOCTYPE html>\r\n<html lang=\"en\">\r\n<head>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\r\n<meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge,chrome=1\">\r\n<title></title>\r\n<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">\r\n<meta name=\"author\" content=\"\">\r\n<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->\r\n<!--[if lt IE 9]>\r\n      <script src=\"http://html5shim.googlecode.com/svn/trunk/html5.js\"></script>\r\n    <![endif]-->\r\n{element: favicon}\r\n<link rel=\"stylesheet\" type=\"text/css\" href=\"/css/system.css\" />\r\n<link rel=\"stylesheet\" type=\"text/css\" href=\"/css/twitter-bootstrap/bootstrap.min.css\" />\r\n<link rel=\"stylesheet\" type=\"text/css\" href=\"/css/twitter-bootstrap/bootstrap.custom.css\" />\r\n{element: css}\r\n<script type=\"text/javascript\" src=\"http://code.jquery.com/jquery-latest.js\"></script>\r\n<script type=\"text/javascript\" src=\"/js/twitter-bootstrap/bootstrap.min.js\"></script>\r\n<script type=\"text/javascript\" src=\"/js/system.js\"></script>\r\n<script type=\"text/javascript\" src=\"/js/plugins/modernizr-2.6.1-respond-1.1.0.min.js\"></script>\r\n{element: javascript}\r\n{element: webpages.analytics}\r\n</head>\r\n<body {element: body_attributes}>\r\n<!--[if lt IE 7]>\r\n    <p class=\"chromeframe\">You are using an outdated browser. <a href=\"http://browsehappy.com/\">Upgrade your browser today</a> or <a href=\"http://www.google.com/chromeframe/?redirect=true\">install Google Chrome Frame</a> to better experience this site.</p>\r\n<![endif]-->\r\n<div class=\"container\">\r\n    {element: twitter-bootstrap/page_title}\r\n    {helper: flash_for_layout}\r\n    {helper: flash_auth_for_layout} \r\n    {menu: test-menu} \r\n    {page: 5}\r\n    {helper: content_for_layout}\r\n    <footer>\r\n        <hr />\r\n        <p>&copy; Company 2012</p>\r\n    </footer>\r\n    {element: sql_dump}\r\n</div>\r\n\r\n</body>\r\n</html>\r\n', NULL, NULL, NULL, NULL, NULL, 'template', 1, '', 'a:4:{i:0;s:1:\"1\";i:1;s:1:\"2\";i:2;s:1:\"3\";i:3;s:1:\"5\";}', NULL, NULL, '2012-12-27 17:51:40', '2012-12-29 11:42:37'),
(5, 0, 'Sidebar', 5, 6, NULL, '<h4>EXAMPLE SIDEBAR</h4>\r\n\r\n<blockquote>\r\n<p>A great product from a great store! Glad I was able to purchase and get it so easily.</p>\r\n<small>Thomas Edison <cite title=\"Source Title\">Wardenclyffe Tower</cite></small></blockquote>\r\n\r\n<blockquote>\r\n<p>It feels great to get customer service and a great product. Can&#39;t wait to come back for more.</p>\r\n<small>Galileo Galilei <cite title=\"Source Title\">Vatican City</cite></small></blockquote>\r\n', NULL, NULL, NULL, NULL, NULL, 'element', NULL, NULL, NULL, '1', '1', '2012-12-27 21:08:58', '2012-12-29 20:19:35'),
(6, 0, 'Error Page', 7, 8, '', '<h1>Page Not Found</h1>\r\n', NULL, NULL, NULL, '', '', 'content', NULL, NULL, NULL, '1', '1', '2012-12-29 18:28:25', '2012-12-29 18:28:25'),
(7, 0, 'About Us', 9, 10, 'About Us', '<p>Your <strong>About Us</strong> page is vital because it&rsquo;s where users go when first trying to determine a level of trust. It&rsquo;s a good idea to give people a fair amount information about yourself and your business. Here are a few things you should touch on:</p>\r\n\r\n<ul>\r\n    <li>Who you are</li>\r\n  <li>Why you do what you do</li>\r\n  <li>Where you are located</li>\r\n  <li>How long you have been in business</li>\r\n  <li>Who are the people on your team</li>\r\n</ul>\r\n\r\n<p>To edit this information turn on edit mode from the admin menu.</p>\r\n', NULL, NULL, NULL, 'about us', 'about us', 'content', NULL, NULL, NULL, '1', '1', '2012-12-29 18:33:08', '2012-12-29 18:33:08'),
(8, 0, 'Footer-Left', 11, 12, NULL, '<p>&copy; 2013 <a data-cke-saved-href=\"/\" href=\"/\">" . $this->options['siteName'] . "</a>. All Rights Reserved.<br><a data-cke-saved-href=\"http://www.cartsimply.com\" href=\"http://www.cartsimply.com\" target=\"_blank\" title=\"Create your own online store with CartSimply.com hosted ecommerce\">Ecommerce Software</a> by CartSimply</p>', NULL, NULL, NULL, NULL, NULL, 'element', NULL, NULL, NULL, '1', '1', '2012-12-29 19:20:53', '2012-12-29 19:20:53'),
(9, 0, 'Footer-Right', 13, 14, NULL, '<p class=\"socialmedia\"><a href=\"http://www.youtube.com\" target=\"_blank\"><img height=\"48\" src=\"/img/icon/icon-social-youtube.png\" width=\"48\" /></a> <a href=\"http://www.twitter.com\" target=\"_blank\"><img height=\"48\" src=\"/img/icon/icon-social-twitter.png\" width=\"48\" /></a> <a href=\"http://www.facebook.com\" target=\"_blank\"><img height=\"48\" src=\"/img/icon/icon-social-facebook.png\" width=\"48\" /></a></p>\r\n', NULL, NULL, NULL, NULL, NULL, 'element', NULL, NULL, NULL, '1', '1', '2012-12-29 20:01:23', '2012-12-29 20:04:43'),
(10, 0, 'Typography', 15, 16, 'Typography', '<p>This is the default homepage.  Complete with default html tags displayed for easy theme styling.  Have fun!!</p><hr /><h1>Heading One <small>small wrapper</small></h1><h2>Heading Two <small>small wrapper</small></h2><h3>Heading Three <small>small wrapper</small></h3><h4>Heading Four <small>small wrapper</small></h4><h5>Heading Five <small>small wrapper</small></h5><h6>Heading Six <small>small wrapper</small></h6><p class=\"muted\">Fusce dapibus, tellus ac cursus commodo, tortor mauris nibh.</p><p class=\"text-warning\">Etiam porta sem malesuada magna mollis euismod.</p><p class=\"text-error\">Donec ullamcorper nulla non metus auctor fringilla.</p><p class=\"text-info\">Aenean eu leo quam. Pellentesque ornare sem lacinia quam venenatis.</p><p class=\"text-success\">Duis mollis, est non commodo luctus, nisi erat porttitor ligula.</p><p>An abbreviation of the word attribute is <abbr title=\"attribute\">attr</abbr></p><address><strong>Acme, Inc.</strong><br>9210 Jetsam Ave, Suite 400<br>San Francisco, CA 90210<br><abbr title=\"Phone\">P:</abbr> (123) 456-7890</address><blockquote>  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>  <small>Someone famous <cite title=\"Source Title\">Source Title</cite></small> </blockquote><blockquote class=\"pull-right\">  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>  <small>Someone famous <cite title=\"Source Title\">Source Title</cite></small> </blockquote><div class=\"clearfix\"></div><dl class=\"dl-horizontal\">  <dt>Description lists</dt>  <dd>A description list is perfect for defining terms.</dd>  <dt>Euismod</dt>  <dd>Vestibulum id ligula porta felis euismod semper eget lacinia odio sem nec elit.</dd>  <dd>Donec id elit non mi porta gravida at eget metus.</dd>  <dt>Malesuada porta</dt>  <dd>Etiam porta sem malesuada magna mollis euismod.</dd>  <dt>Felis euismod semper eget lacinia</dt>  <dd>Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</dd></dl><h2>Various Default Table Classes</h2><table class=\"table\">  <thead>    <tr>      <th>#</th>      <th>First Name</th>      <th>Last Name</th>      <th>Username</th>    </tr>  </thead>  <tbody>    <tr>      <td>1</td>      <td>Mark</td>      <td>Otto</td>      <td>@mdo</td>    </tr>    <tr>      <td>2</td>      <td>Jacob</td>      <td>Thornton</td>      <td>@fat</td>    </tr>    <tr>      <td>3</td>      <td>Larry</td>      <td>the Bird</td>      <td>@twitter</td>    </tr>  </tbody></table><table class=\"table table-striped\">  <thead>    <tr>      <th>#</th>      <th>First Name</th>      <th>Last Name</th>      <th>Username</th>    </tr>  </thead>  <tbody>    <tr>      <td>1</td>      <td>Mark</td>      <td>Otto</td>      <td>@mdo</td>    </tr>    <tr>      <td>2</td>      <td>Jacob</td>      <td>Thornton</td>      <td>@fat</td>    </tr>    <tr>      <td>3</td>      <td>Larry</td>      <td>the Bird</td>      <td>@twitter</td>    </tr>  </tbody></table><table class=\"table table-bordered\">  <thead>    <tr>      <th>#</th>      <th>First Name</th>      <th>Last Name</th>      <th>Username</th>    </tr>  </thead>  <tbody>    <tr>      <td rowspan=\"2\">1</td>      <td>Mark</td>      <td>Otto</td>      <td>@mdo</td>    </tr>    <tr>      <td>Mark</td>      <td>Otto</td>      <td>@TwBootstrap</td>    </tr>    <tr>      <td>2</td>      <td>Jacob</td>      <td>Thornton</td>      <td>@fat</td>    </tr>    <tr>      <td>3</td>      <td colspan=\"2\">Larry the Bird</td>      <td>@twitter</td>    </tr>  </tbody></table><table class=\"table table-hover\">  <thead>    <tr>      <th>#</th>      <th>First Name</th>      <th>Last Name</th>      <th>Username</th>    </tr>  </thead>  <tbody>    <tr>      <td>1</td>      <td>Mark</td>      <td>Otto</td>      <td>@mdo</td>    </tr>    <tr>      <td>2</td>      <td>Jacob</td>      <td>Thornton</td>      <td>@fat</td>    </tr>    <tr>      <td>3</td>      <td colspan=\"2\">Larry the Bird</td>      <td>@twitter</td>    </tr>  </tbody></table><table class=\"table table-condensed\">  <thead>    <tr>      <th>#</th>      <th>First Name</th>      <th>Last Name</th>      <th>Username</th>    </tr>  </thead>  <tbody>    <tr>      <td>1</td>      <td>Mark</td>      <td>Otto</td>      <td>@mdo</td>    </tr>    <tr>      <td>2</td>      <td>Jacob</td>      <td>Thornton</td>      <td>@fat</td>    </tr>    <tr>      <td>3</td>      <td colspan=\"2\">Larry the Bird</td>      <td>@twitter</td>    </tr>  </tbody></table><table class=\"table\">  <thead>    <tr>      <th>#</th>      <th>Product</th>      <th>Payment Taken</th>      <th>Status</th>    </tr>  </thead>  <tbody>    <tr class=\"success\">      <td>1</td>      <td>TB - Monthly</td>      <td>01/04/2012</td>      <td>Approved</td>    </tr>    <tr class=\"error\">      <td>2</td>      <td>TB - Monthly</td>      <td>02/04/2012</td>      <td>Declined</td>    </tr>    <tr class=\"warning\">      <td>3</td>      <td>TB - Monthly</td>      <td>03/04/2012</td>      <td>Pending</td>    </tr>    <tr class=\"info\">      <td>4</td>      <td>TB - Monthly</td>      <td>04/04/2012</td>      <td>Call in to confirm</td>    </tr>  </tbody></table><h2>Form Styles</h2><form action=\"/webpages/webpages/view/1?url=webpages%2Fwebpages%2Fview%2F1\" id=\"WebpageViewForm\" method=\"post\" accept-charset=\"utf-8\">  <div style=\"display:none;\">    <input type=\"hidden\" name=\"_method\" value=\"POST\"/>  </div>  <fieldset>  <legend>Some Legend</legend>  <div class=\"input text\" data-role=\"fieldcontain\">    <label for=\"WebpageLabelName\">Label Name</label>    <input name=\"data[Webpage][labelName]\" placeholder=\"Type something...\" type=\"text\" id=\"WebpageLabelName\"/>    <span class=\"help-block\">Some text in the after index</span></div>  <div class=\"input checkbox\" data-role=\"fieldcontain\">    <input type=\"hidden\" name=\"data[Webpage][singleCheckBox]\" id=\"WebpageSingleCheckBox_\" value=\"0\"/>    <input type=\"checkbox\" name=\"data[Webpage][singleCheckBox]\"  value=\"1\" id=\"WebpageSingleCheckBox\"/>    <label for=\"WebpageSingleCheckBox\">Single Check Box</label>  </div>  <div class=\"input radio\" data-role=\"fieldcontain\">    <input type=\"hidden\" name=\"data[Webpage][radio2Buttons]\" id=\"WebpageRadio2Buttons_\" value=\"\"/>    <input type=\"radio\" name=\"data[Webpage][radio2Buttons]\" id=\"WebpageRadio2Buttons0\"  value=\"0\" />    <label for=\"WebpageRadio2Buttons0\">radio option one</label>    <input type=\"radio\" name=\"data[Webpage][radio2Buttons]\" id=\"WebpageRadio2Buttons1\"  value=\"1\" />    <label for=\"WebpageRadio2Buttons1\">radio option two</label>    <input type=\"radio\" name=\"data[Webpage][radio2Buttons]\" id=\"WebpageRadio2Buttons2\"  value=\"2\" />    <label for=\"WebpageRadio2Buttons2\">radio option three</label>  </div>  <div class=\"input radio\" data-role=\"fieldcontain\">    <fieldset>      <legend>radio set with legend</legend>      <input type=\"hidden\" name=\"data[Webpage][radioButtons]\" id=\"WebpageRadioButtons_\" value=\"\"/>      <input type=\"radio\" name=\"data[Webpage][radioButtons]\" id=\"WebpageRadioButtons0\"  value=\"0\" />      <label for=\"WebpageRadioButtons0\">option one</label>      <input type=\"radio\" name=\"data[Webpage][radioButtons]\" id=\"WebpageRadioButtons1\"  value=\"1\" />      <label for=\"WebpageRadioButtons1\">option two</label>      <input type=\"radio\" name=\"data[Webpage][radioButtons]\" id=\"WebpageRadioButtons2\"  value=\"2\" />      <label for=\"WebpageRadioButtons2\">option three</label>    </fieldset>  </div>  <div class=\"input select\" data-role=\"fieldcontain\">    <label for=\"WebpageSelectButtons\">Select One</label>    <select name=\"data[Webpage][selectButtons]\" id=\"WebpageSelectButtons\">      <option value=\"0\">option one</option>      <option value=\"1\">option two</option>      <option value=\"2\">option three</option>    </select>  </div>  <div class=\"input select\" data-role=\"fieldcontain\">    <label for=\"WebpageSelectButtons\">Select Multiple</label>    <input type=\"hidden\" name=\"data[Webpage][selectButtons]\" value=\"\" id=\"WebpageSelectButtons_\"/>    <select name=\"data[Webpage][selectButtons][]\" multiple=\"multiple\" id=\"WebpageSelectButtons\">      <option value=\"0\">option one</option>      <option value=\"1\">option two</option>      <option value=\"2\">option three</option>    </select>  </div>  <div class=\"input select\" data-role=\"fieldcontain\">    <label for=\"WebpageSelectButtons\">Select Multiple</label>    <input type=\"hidden\" name=\"data[Webpage][selectButtons]\" value=\"\" id=\"WebpageSelectButtons\"/>    <div class=\"checkbox\">      <input type=\"checkbox\" name=\"data[Webpage][selectButtons][]\" value=\"0\" id=\"WebpageSelectButtons0\" />      <label for=\"WebpageSelectButtons0\">option one</label>    </div>    <div class=\"checkbox\">      <input type=\"checkbox\" name=\"data[Webpage][selectButtons][]\" value=\"1\" id=\"WebpageSelectButtons1\" />      <label for=\"WebpageSelectButtons1\">option two</label>    </div>    <div class=\"checkbox\">      <input type=\"checkbox\" name=\"data[Webpage][selectButtons][]\" value=\"2\" id=\"WebpageSelectButtons2\" />      <label for=\"WebpageSelectButtons2\">option three</label>    </div>  </div>  <div class=\"input textarea\" data-role=\"fieldcontain\">    <label for=\"WebpageTextArea\">Text Area</label>    <textarea name=\"data[Webpage][textArea]\" cols=\"30\" rows=\"6\" id=\"WebpageTextArea\"></textarea>  </div>  <div class=\"submit\">    <input  type=\"submit\" value=\"Submit\"/>  </div></form></fieldset><h2>Unordered List Styles</h2><ul>  <li>List Item One</li>  <li>List Item Two    <ul>      <li>Sub Item One        <ul>          <li>Sub sub item one</li>        </ul>      </li>      <li>Sub Item Two</li>      <li>Sub Item Three</li>    </ul>  </li>  <li>List Item Three</li></ul><h2>Ordered List Styles</h2><ol>  <li>List Item One</li>  <li>List Item Two    <ol>      <li>Sub Item One        <ol>          <li>Sub sub item one</li>        </ol>      </li>      <li>Sub Item Two</li>      <li>Sub Item Three</li>    </ol>  </li>  <li>List Item Three</li></ol><!-- Example row of columns --><div class=\"row\">  <div class=\"span4\">    <h2>Heading</h2>    <p class=\"lead\">Make a paragraph stand out by adding class called .lead.</p>    <p>Donec id elit non mi porta <strong>strong bold <em>text</strong> at eget metus. Fusce</em> dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>    <p><a class=\"btn\" href=\"#\">View details &raquo;</a></p>  </div>  <div class=\"span4\">    <h2>Heading</h2>    <p class=\"lead\">Make a paragraph stand out by adding class called .lead.</p>    <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>    <p><a class=\"btn\" href=\"#\">View details &raquo;</a></p>  </div>  <div class=\"span4\">    <h2>Heading</h2>    <p class=\"lead\">Make a paragraph stand out by adding class called .lead.</p>    <p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>    <p><a class=\"btn\" href=\"#\">View details &raquo;</a></p>  </div></div><hr /><h2>Live grid example</h2><p>The default grid system utilizes <strong>12 columns</strong>, responsive columns become fluid and stack vertically.</p><div class=\"row\">  <div class=\"span1\">.span1</div>  <div class=\"span1\">.span1</div>  <div class=\"span1\">.span1</div>  <div class=\"span1\">.span1</div>  <div class=\"span1\">.span1</div>  <div class=\"span1\">.span1</div>  <div class=\"span1\">.span1</div>  <div class=\"span1\">.span1</div>  <div class=\"span1\">.span1</div>  <div class=\"span1\">.span1</div>  <div class=\"span1\">.span1</div>  <div class=\"span1\">.span1</div></div><div class=\"row show-grid\">  <div class=\"span2\">.span2</div>  <div class=\"span3\">.span3</div>  <div class=\"span4\">.span4</div>  <div class=\"span2\">.span2</div>  <div class=\"span1\">.span1</div></div><div class=\"row show-grid\">  <div class=\"span9\">.span9</div>  <div class=\"span3\">.span3</div></div><hr /><h3>This is a pre tag with the class .prettyprint & .linenums</h3><pre class=\"prettyprint linenums\"><div class=\"row\"&gt;  <div class=\"span4\"&gt;...</div&gt;  <div class=\"span8\"&gt;...</div&gt;</div&gt;</pre>', NULL, NULL, NULL, NULL, NULL, 'content', NULL, NULL, NULL, NULL, NULL, '2012-12-31 01:10:12', '2012-12-31 01:10:16'),
(11, 0, 'Contact Us', 17, 18, 'Contact Us', '<h1>Contact Us</h1>\r\n\r\n<p>{form: 50e1325f-1750-4bea-bfc5-102245a3a949}</p>\r\n', NULL, NULL, NULL, '', '', 'content', NULL, NULL, NULL, '1', '1', '2012-12-30 22:37:48', '2012-12-30 22:37:48');";

        $dataStrings[] = "INSERT INTO `webpage_menus` (`id`, `parent_id`, `lft`, `rght`, `name`, `code`, `type`, `params`, `css_id`, `css_class`, `menu_id`, `item_url`, `item_text`, `item_before`, `item_after`, `item_css_class`, `item_css_id`, `item_target`, `item_title`, `item_attributes`, `item_auto_authorize`, `order`, `creator_id`, `modifier_id`, `created`, `modified`) VALUES
('50dd2c0b-3904-4100-9076-627145a3a949', '', 1, 14, 'Main Menu', 'main-menu', '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2012-12-27 21:20:11', '2012-12-27 21:20:11'),
('50dd2c18-6250-49ed-8baf-627145a3a949', '50dd2c0b-3904-4100-9076-627145a3a949', 4, 5, NULL, NULL, NULL, NULL, NULL, NULL, '50dd2c0b-3904-4100-9076-627145a3a949', '/products', 'Products', '', '', '', '', '', '', '', 0, 2, '1', '1', '2012-12-27 21:20:24', '2012-12-29 18:58:42'),
('50dfa428-75ac-4050-95b6-031c45a3a949', '50dfa43d-2f7c-46b2-a955-031c45a3a949', 9, 10, NULL, NULL, NULL, NULL, NULL, NULL, '50dd2c0b-3904-4100-9076-627145a3a949', '/blogs', 'Blog', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, '1', '1', '2012-12-29 18:17:12', '2012-12-29 18:58:42'),
('50dfa43d-2f7c-46b2-a955-031c45a3a949', '50dd2c0b-3904-4100-9076-627145a3a949', 6, 11, NULL, NULL, NULL, NULL, NULL, NULL, '50dd2c0b-3904-4100-9076-627145a3a949', '/about', 'About Us', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '1', '1', '2012-12-29 18:17:33', '2012-12-29 18:58:42'),
('50dfa444-9630-4a04-9190-031c45a3a949', '50dd2c0b-3904-4100-9076-627145a3a949', 2, 3, NULL, NULL, NULL, NULL, NULL, NULL, '50dd2c0b-3904-4100-9076-627145a3a949', '/', 'Home', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '1', '1', '2012-12-29 18:17:40', '2012-12-29 18:58:42'),
('50dfaddd-8dcc-4ed3-9d4a-6faa45a3a949', '50dfa43d-2f7c-46b2-a955-031c45a3a949', 7, 8, NULL, NULL, NULL, NULL, NULL, NULL, '50dd2c0b-3904-4100-9076-627145a3a949', '/about', 'About Us', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, '1', '1', '2012-12-29 18:58:37', '2012-12-29 18:58:42'),
('50e1a9ae-a174-4f55-9583-1fd745a3a949', '50dd2c0b-3904-4100-9076-627145a3a949', 12, 13, NULL, NULL, NULL, NULL, NULL, NULL, '50dd2c0b-3904-4100-9076-627145a3a949', '/contact', 'Contact Us', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', '1', '2012-12-31 07:05:18', '2012-12-31 07:05:18');";

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

}
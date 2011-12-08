<?php

App::uses('Controller', 'Controller');
App::uses('ComponentCollection', 'Controller');
App::uses('AclComponent', 'Controller/Component');
App::uses('DbAcl', 'Model');

class PrivilegesAppController extends AppController {
	
/** 
 * A list of controllers to exclude from privileges
 */
	public $controllerExclusions = array(
		'AppController',
		'AppErrorController',
		'ConditionsController',
		);
/** 
 * A list of plugins to exclude from privileges
 */
	public $pluginExclusions = array(
		'AclExtras',
		'Calendars',
		'Forum',
		'Notifications',
		'Privileges',
		'Utils',
		);
	
/**
 * Contains instance of AclComponent
 *
 * @var AclComponent
 * @access public
 */
	public $Acl;

/**
 * Contains arguments parsed from the command line.
 *
 * @var array
 * @access public
 */
	public $args;

/**
 * Contains database source to use
 *
 * @var string
 * @access public
 */
	public $dataSource = 'default';

/**
 * Root node name.
 *
 * @var string
 **/
	public $rootNode = 'controllers';

/**
 * Internal Clean Actions switch
 *
 * @var boolean
 **/
	public $_clean = false;

/**
 * Start up And load Acl Component / Aco model
 *
 * @return void
 **/
	public function beforeFilter() {
		#parent::__construct();
		$collection = new ComponentCollection();
		$this->Acl = new AclComponent($collection);
		$controller = null;
		$this->Acl->startup($controller);
		$this->Aco = $this->Acl->Aco;
		
		$lastPlugins = CakeSession::read('Privileges.lastPlugin');
		$this->pluginExclusions = !empty($lastPlugins) ? array_merge($lastPlugins, $this->pluginExclusions) : $this->pluginExclusions;
	}
	
	function out($out) {
		#debug($out);
	}

/**
 * Sync the ACO table
 *
 * @return void
 **/
	function aco_sync() {
		$this->_clean = true;
		$this->aco_update();
	}
/**
 * Updates the Aco Tree with new controller actions.
 *
 * @return void
 **/
	function aco_update() {
		$root = $this->_checkNode('controller', $this->rootNode, $this->rootNode, null);
		$controllers = $this->getControllerList();
		$this->_updateControllers($root, $controllers);
		$plugins = array_diff(CakePlugin::loaded(), $this->pluginExclusions);
		
		foreach ($plugins as $plugin) {
			$controllers = $this->getControllerList($plugin);

			$path = $this->rootNode . '/' . $plugin;
			$pluginRoot = $this->_checkNode('plugin', $path, $plugin, $root['Aco']['id']);
			$this->_updateControllers($pluginRoot, $controllers, $plugin);
			
			# zuha, run aco_update once and update the session so that plugin is ignored next go around
			$lastPluginSession = CakeSession::read('Privileges.lastPlugin');
			$lastPluginSession[] = $plugin;
			CakeSession::write('Privileges.lastPlugin', $lastPluginSession);
			break;
		}
		$this->out(__('<success>Aco Update Complete</success>'));
		return true;
	}

/**
 * Kills the session vars so aco_sync can be restarted
 */
	function clear_session() {
		CakeSession::write('Privileges.lastPlugin', null);
	}

/**
 * Updates a collection of controllers.
 *
 * @param array $root Array or ACO information for root node.
 * @param array $controllers Array of Controllers
 * @param string $plugin Name of the plugin you are making controllers for.
 * @return void
 */
	function _updateControllers($root, $controllers, $plugin = null) {
		$dotPlugin = $pluginPath = $plugin;
		if ($plugin) {
			$dotPlugin .= '.';
			$pluginPath .= '/';
		}
		$appIndex = array_search($plugin . 'AppController', $controllers);
		if ($appIndex !== false) {
			App::uses($plugin . 'AppController', $dotPlugin . 'Controller');
			unset($controllers[$appIndex]);
		}
		// look at each controller
		foreach ($controllers as $controller) {
			set_time_limit(240);
			App::uses($controller, $dotPlugin . 'Controller');
			$controllerName = preg_replace('/Controller$/', '', $controller);

			$path = $this->rootNode . '/' . $pluginPath . $controllerName;
			# zuha add for types
			if (!empty($pluginPath)) {
				$type = 'pcontroller';
			} else {
				$type = 'controller';
			}
			$controllerNode = $this->_checkNode($type, $path, $controllerName, $root['Aco']['id']);
			$this->_checkMethods($controller, $controllerName, $controllerNode, $pluginPath);
		}
		if ($this->_clean) {
			if (!$plugin) {
				$controllers = array_merge($controllers, App::objects('plugin', null, false));
			}
			$controllerFlip = array_flip($controllers);
			
			
			$this->Aco->id = $root['Aco']['id'];
			$controllerNodes = $this->Aco->children(null, true);
			foreach ($controllerNodes as $ctrlNode) {
				$name = $ctrlNode['Aco']['alias'] . 'Controller';
				$sessionPlugins = CakeSession::read('Privileges.lastPlugin');
				$sessionPlugins = !empty($sessionPlugins) ? $sessionPlugins : array();
				if (!isset($controllerFlip[$name]) && !in_array($ctrlNode['Aco']['alias'], $sessionPlugins)) {
					if ($this->Aco->delete($ctrlNode['Aco']['id'])) {
						$this->out(__('Deleted %s and all children', $this->rootNode . '/' . $ctrlNode['Aco']['alias']));
					}
				}
			}
		}
	}

/**
 * Get a list of controllers in the app and plugins.
 *
 * Returns an array of path => import notation.
 *
 * @param string $plugin Name of plugin to get controllers for
 * @return array
 **/
	function getControllerList($plugin = null) {
		if (!$plugin) {
			$controllers = App::objects('Controller', null, false);
		} else {
			$controllers = App::objects($plugin . '.Controller', null, false);
		}
		return array_diff($controllers, $this->controllerExclusions);
	}

/**
 * Check a node for existance, create it if it doesn't exist.
 *
 * @param string $path
 * @param string $alias
 * @param int $parentId
 * @return array Aco Node array
 */
	function _checkNode($type = 'controller', $path, $alias, $parentId = null) {
		$node = $this->Aco->node($path);
		if (!$node) {
			$this->Aco->create(array('parent_id' => $parentId, 'model' => null, 'alias' => $alias, 'type' => $type));
			$node = $this->Aco->save();
			$node['Aco']['id'] = $this->Aco->id;
			$this->out(__('Created Aco node: %s', $path));
		} else {
			$node = $node[0];
		}
		return $node;
	}

/**
 * Check and Add/delete controller Methods
 *
 * @param string $controller
 * @param array $node
 * @param string $plugin Name of plugin
 * @return void
 */
	function _checkMethods($className, $controllerName, $node, $pluginPath = false) {		
		$baseMethods = get_class_methods('Controller');
		$actions = get_class_methods($className);
		$methods = array_diff($actions, $baseMethods);
		foreach ($methods as $action) {
			# zuha functions to ignore --  || $action == 'isAuthorized'
			if (strpos($action, '_', 0) === 0 || $action == 'isAuthorized' || $action == 'runcron' || $action == 'authentication') {
				continue;
			}
			$path = $this->rootNode . '/' . $pluginPath . $controllerName . '/' . $action;
			# zuha add for types
			if (!empty($pluginPath)) {
				$type = 'paction';
			} else {
				$type = 'action';
			}
			$this->_checkNode($type, $path, $action, $node['Aco']['id']);
		}

		if ($this->_clean) {
			$actionNodes = $this->Aco->children($node['Aco']['id']);
			$methodFlip = array_flip($methods);
			foreach ($actionNodes as $action) {
				if (!isset($methodFlip[$action['Aco']['alias']])) {
					$this->Aco->id = $action['Aco']['id'];
					if ($this->Aco->delete()) {
						$path = $this->rootNode . '/' . $controllerName . '/' . $action['Aco']['alias'];
						$this->out(__('Deleted Aco node %s', $path));
					}
				}
			}
		}
		return true;
	}



/**
 * Verify a Acl Tree
 *
 * @param string $type The type of Acl Node to verify
 * @access public
 * @return void
 */
	function verify() {
		
		break;
		
		$type = Inflector::camelize($this->args[0]);
		$return = $this->Acl->{$type}->verify();
		if ($return === true) {
			$this->out(__('Tree is valid and strong'));
		} else {
			$this->err(print_r($return, true));
			return false;
		}
	}
/**
 * Recover an Acl Tree
 *
 * @param string $type The Type of Acl Node to recover
 * @access public
 * @return void
 */
	function recover() {
		
		break;
		
		$type = Inflector::camelize($this->args[0]);
		$return = $this->Acl->{$type}->recover();
		if ($return === true) {
			$this->out(__('Tree has been recovered, or tree did not need recovery.'));
		} else {
			$this->err(__('<error>Tree recovery failed.</error>'));
			return false;
		}
	}

}

?>
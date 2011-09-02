<?php
/**
 * Settings Controller
 *
 * Used to set global constants that can be used throughout the entire app.
 * All data in this table is loaded on app start up (and hopefully cached).
 * The purpose is to have a central database driven place where you can customize
 * the application. 
 *
 * PHP versions 5
 *
 * Zuha(tm) : Business Management Applications (http://zuha.com)
 * Copyright 2009-2010, Zuha Foundation Inc. (http://zuha.org)
 *
 * Licensed under GPL v3 License
 * Must retain the above copyright notice and release modifications publicly.
 *
 * @copyright     Copyright 2009-2010, Zuha Foundation Inc. (http://zuha.com)
 * @link          http://zuha.com Zuha� Project
 * @package       zuha
 * @subpackage    zuha.app.controllers
 * @since         Zuha(tm) v 0.0.1
 * @license       GPL v3 License (http://www.gnu.org/licenses/gpl.html) and Future Versions
 * @todo		  Make sure that settings are cached for a very long time, because they are not needed to be refreshed often at all. 
 */
class SettingsController extends AppController {

	var $name = 'Settings';
    var $uses = array('Setting', 'Template');


	function admin_update_defaults() {
		if ($this->Setting->writeDefaultsIniData()) {
			$this->Session->setFlash(__('Defaults update successful.', true));
			$this->redirect($this->referer());
		} else {
			$this->Session->setFlash(__('Defaults update failed. Please, try again.', true));
		}
		
	}
	
	function admin_update_settings() {
		if ($this->Setting->writeSettingsIniData()) {
			$this->Session->setFlash(__('Settings update successful.', true));
			$this->redirect($this->referer());
		} else {
			$this->Session->setFlash(__('Settings update failed. Please, try again.', true));
		}
	}
	
	function admin_index() {		
		$this->paginate = array(
			'fields' => array(
				'id',
				'displayName',
				'description',
				),
			'order' => array(
				'Setting.type',
				'Setting.name',
				),
			'limit' => 25,
			);
		$this->set('settings', $this->paginate());
		$this->set('displayName', 'displayName');
		$this->set('displayDescription', 'description'); 
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Setting.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('setting', $this->Setting->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			if ($this->Setting->add($this->data)) {
				$this->Session->setFlash(__('The Setting has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Setting could not be saved. Please, try again.', true));
			}
		}
		$types = $this->Setting->types();
		$this->set(compact('types')); 
	}
	
	function admin_names($typeName = null) {
		$settings = $this->Setting->getNames($typeName);
		$this->set(compact('settings'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data) && empty($this->params['named'])) {
			$this->Session->setFlash(__('Invalid Setting', true));
			$this->redirect(array('action'=>'index'));
		} 
		if (!empty($this->data)) {
			if ($this->Setting->add($this->data)) {
				$this->Session->setFlash(__('The Setting has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Setting could not be saved. Please, try again.', true));
			}
		}
		if (!empty($this->params['named'])) {
			$this->data = $this->Setting->find('first', array(
				'conditions' => array(
					'type_id' => enum(null, $this->params['named']['type']), 
					'name' => $this->params['named']['name'],
					),
				));
			$this->set('typeId', enum(null, $this->params['named']['type'])); 
			$this->data['Setting']['name'] = $this->params['named']['name'];
			$this->data['Setting']['description'] = $this->Setting->getDescription($this->params['named']['type'], $this->params['named']['name']); 
		}
		if (empty($this->data)) {
			$this->data = $this->Setting->read(null, $id);
		}
		$types = $this->Setting->types();
		$this->set(compact('types')); 
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Setting', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Setting->delete($id)) {
			if ($this->Setting->writeSettingsIniData()) {
				$this->Session->setFlash(__('Setting deleted', true));
				$this->redirect(array('action'=>'index'));
			}
		}
	}

































/**
 * THIS USED TO BE IN APP_CONTROLLER, BUT WASN'T USED ANYMORE SO ITS STORED HERE FOR SAFE KEEPING FOR  A LITTLE WHILE LONGER.
 * 6/12/2011  ::  REMOVE THESE FUNCTIONS BELOW IF YOU SEE THIS MESSAGE SOMETIME AFTER ACL IS CONSIDERED 100% FINISHED 
 *
 *
 *
 *
 * Build ACL is a function used for updating the acos table with all available plugins and controller methods.
 * 
 * Was extended to make it possible to do a single controller or plugin at a time, instead of a full rebuild.
 * @todo We need to add default index, view, add, edit, delete, admin_index, admin_view, admin_add, admin_edit, admin_delete functions, if we can figure out a way so that particular controllers can turn them off, and keep the build_acl stuff below knowledgeable of it, so that acos stay clean. 
 * @link http://book.cakephp.org/view/648/Setting-up-permissions
 * @link http://book.cakephp.org/view/1549/An-Automated-tool-for-creating-ACOs
 */	
	function __build_acl($specifiedController = null) {
		if (!Configure::read('debug')) {
			return $this->_stop();
		}
		$log = array();

		$aco =& $this->Acl->Aco;
		$root = $aco->node('controllers');
		
		if (!$root) {
			$aco->create(array('parent_id' => null, 'model' => null, 'alias' => 'controllers' , 'type'=>'controller'));
			$root = $aco->save();
			$root['Aco']['id'] = $aco->id; 
			$log[] = 'Created Aco node for controllers';
		} else {
			$root = $root[0];
		}   

		App::import('Core', 'File');
		$Controllers = Configure::listObjects('controller');
		$appIndex = array_search('App', $Controllers);
		if ($appIndex !== false ) {
			unset($Controllers[$appIndex]);
		}
		$baseMethods = get_class_methods('Controller');
		$baseMethods[] = 'buildAcl';

		$Plugins = $this->_getPluginControllerNames();
		$Controllers = array_merge($Controllers, $Plugins);
		
		# See if a specific plugin or controller was specified
		# And if it was, then we only need to build_acl for that one
		if (isset($specifiedController)) {
			foreach ($Controllers as $controller) {
				# check to see if the specified controller is already installed
				if(strstr($controller, $specifiedController)) {
					$newControllers[] = $controller;
				}
			}
			if (isset($newControllers)) {
				$Controllers = $newControllers;
			} else {
				# if the specified controller doesn't exist send it back
				return false;
			}
		}

		// look at each controller in app/controllers
		foreach ($Controllers as $ctrlName) {
			$methods['action'] = $this->_getClassMethods($this->_getPluginControllerPath($ctrlName));

			// Do all Plugins First
			if ($this->_isPlugin($ctrlName)){
				
				$pluginNode = $aco->node('controllers/'.$this->_getPluginName($ctrlName));
				if (!$pluginNode) {
					$aco->create(array('parent_id' => $root['Aco']['id'], 'model' => null, 'alias' => $this->_getPluginName($ctrlName) , 'type'=>'plugin'));
					$pluginNode = $aco->save();
					$pluginNode['Aco']['id'] = $aco->id;
					$log[] = 'Created Aco node for ' . $this->_getPluginName($ctrlName) . ' Plugin';
				}
			}
			// find / make controller node
			$controllerNode = $aco->node('controllers/'.$ctrlName);
			if (!$controllerNode) {
				if ($this->_isPlugin($ctrlName)){
					$methods["type"] = 'paction';
					$pluginNode = $aco->node('controllers/' . $this->_getPluginName($ctrlName));
					$aco->create(array('parent_id' => $pluginNode['0']['Aco']['id'], 'model' => null, 'alias' => $this->_getPluginControllerName($ctrlName) , 'type'=>'pcontroller'));
					$controllerNode = $aco->save();
					$controllerNode['Aco']['id'] = $aco->id;
					$log[] = 'Created Aco node for ' . $this->_getPluginControllerName($ctrlName) . ' ' . $this->_getPluginName($ctrlName) . ' Plugin Controller';
				} else {
					$methods["type"] = 'action';
					$aco->create(array('parent_id' => $root['Aco']['id'], 'model' => null, 'alias' => $ctrlName , 'type'=>'controller'));
					$controllerNode = $aco->save();
					$controllerNode['Aco']['id'] = $aco->id;
					$log[] = 'Created Aco node for ' . $ctrlName;
				}
			} else {
				$controllerNode = $controllerNode[0];
			}

			//clean the methods. to remove those in Controller and private actions.
			foreach ($methods['action'] as $k => $method) {
				if (strpos($method, '_', 0) === 0) {
					unset($methods[$k]);
					continue;
				}
				if (in_array($method, $baseMethods)) {
					unset($methods[$k]);
					continue;
				}
				$methodNode = $aco->node('controllers/'.$ctrlName.'/'.$method);
				if (!$methodNode) {
					$aco->create(array('parent_id' => $controllerNode['Aco']['id'], 'model' => null, 'alias' => $method , 'type'=>$methods['type']));
					$methodNode = $aco->save();
					$log[] = 'Created Aco node for '. $method;
				}
			}
		}
		if(count($log)>0) {
			debug($log);
			return true;
		}
	}


/**
 * Get the actions (or methods or functions) defined in controller.
 *
 * @todo Not entirely sure that this is working if you were to pick a /sites customization and add a new plugin controller or add a new plugin controller method, whether that method will be identified and have an aco created for it. Just need to verify whether it is or not and remove this todo.
 * @todo Very sure that we're pulling methods from else where in this application, we can reuse this code most likely and eliminate some unecessary code. Need to search the app for other places where we call all methods and use this function instead if possible, and then delete this todo. 
 * @todo This function could be expanded to work for models as well, by adding a $modelName param.
 * @param {ctrlName} the controller to pull methods from
 */
	function _getClassMethods($ctrlName = null) {
		App::import('Controller', $ctrlName);
		if (strlen(strstr($ctrlName, '.')) > 0) {
			// plugin's controller
			$num = strpos($ctrlName, '.');
			$ctrlName = substr($ctrlName, $num+1);
		}
		$ctrlclass = $ctrlName . 'Controller';
		$methods = get_class_methods($ctrlclass);

		# Add scaffold defaults if scaffolds are being used
		# @todo This section was commented out because it is not working.  It runs even if scaffold is off.
		/*$properties = get_class_vars($ctrlclass);
		if (array_key_exists('scaffold',$properties)) {
			if($properties['scaffold'] == 'admin') {
				$methods = array_merge($methods, array('admin_add', 'admin_edit', 'admin_index', 'admin_view', 'admin_delete'));
			} else {
				$methods = array_merge($methods, array('add', 'edit', 'index', 'view', 'delete'));
			}
		}*/
		return $methods;
	}

	function _isPlugin($ctrlName = null) {
		$arr = String::tokenize($ctrlName, '/');
		if (count($arr) > 1) {
			return true;
		} else {
			return false;
		}
	}

	function _getPluginControllerPath($ctrlName = null) {
		$arr = String::tokenize($ctrlName, '/');
		if (count($arr) == 2) {
			return $arr[0] . '.' . $arr[1];
		} else {
			return $arr[0];
		}
	}

	function _getPluginName($ctrlName = null) {
		$arr = String::tokenize($ctrlName, '/');
		if (count($arr) == 2) {
			return $arr[0];
		} else {
			return false;
		}
	}

	function _getPluginControllerName($ctrlName = null) {
		$arr = String::tokenize($ctrlName, '/');
		if (count($arr) == 2) {
			return $arr[1];
		} else {
			return false;
		}
	}

/**
 * Get the names of the plugin controllers ...
 * 
 * This function will get an array of the plugin controller names, and
 * also makes sure the controllers are available for us to get the 
 * method names by doing an App::import for each plugin controller.
 *
 * @return array of plugin names.
 *
 */
	function _getPluginControllerNames() {
		App::import('Core', 'File', 'Folder');
		$paths = Configure::getInstance();
		$folder =& new Folder();
		$folder->cd(APP . 'plugins');
		
		# get the list of plugins
		$Plugins = $folder->read();
		$Plugins = $Plugins[0];
		
		# get the list of core plugins
		$folder->cd(ROOT . DS . 'app'. DS . 'plugins');
		$CorePlugins = $folder->read();
		
		# merge the core and the sites directory and eliminate duplicates
		$Plugins = am($CorePlugins[0], $Plugins[0]);
		$Plugins = array_unique($Plugins);
		
		$arr = array();
		

		# Loop through the plugins
		foreach($Plugins as $pluginName) {
			# Change directory to the plugin
			$didCD = $folder->cd(ROOT . DS . 'app'. DS . 'plugins'. DS . $pluginName . DS . 'controllers');
			# Get a list of the files that have a file name that ends with controller.php
			$files = $folder->findRecursive('.*_controller\.php');
			# support for multi site setups by searching the sites app as well.
			$didCD = $folder->cd(APP . 'plugins'. DS . $pluginName . DS . 'controllers');
			$files = am($files, $folder->findRecursive('.*_controller\.php'));
			$files = array_unique($files);

			# Loop through the controllers we found in the plugins directory
			foreach($files as $fileName) {
				# Get the base file name
				$file = basename($fileName);

				# Get the controller name
				$file = Inflector::camelize(substr($file, 0, strlen($file)-strlen('_controller.php')));
				if (!preg_match('/^'. Inflector::humanize($pluginName). 'App/', $file)) {
					if (!App::import('Controller', $pluginName.'.'.$file)) {
						debug('Error importing '.$file.' for plugin '.$pluginName);
					} else {
						/// Now prepend the Plugin name ...
						// This is required to allow us to fetch the method names.
						$arr[] = Inflector::humanize($pluginName) . "/" . $file;
					}
				}
			}
		}
		return $arr;
	}
	
	
################################ END ACO ADD #############################
##########################################################################



}
?>
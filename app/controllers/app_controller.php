<?php
/**
 * App Wide Methods
 *
 * File is used for app wide convenience functions and logic and settings. 
 * Methods in this file can be accessed from any other controller in the app.
 *
 * PHP versions 5
 *
 * Zuha(tm) : Business Management Applications (http://zuha.com)
 * Copyright 2009-2010, Zuha Foundation Inc. (http://zuhafoundation.org)
 *
 * Licensed under GPL v3 License
 * Must retain the above copyright notice and release modifications publicly.
 *
 * @copyright     Copyright 2009-2010, Zuha Foundation Inc. (http://zuha.com)
 * @link          http://zuha.com Zuha™ Project
 * @package       zuha
 * @subpackage    zuha.app
 * @since         Zuha(tm) v 0.0.1
 * @license       GPL v3 License (http://www.gnu.org/licenses/gpl.html) and Future Versions
 */
class AppController extends Controller {
	
    var $uses = array('Setting', 'Condition', 'Webpages.Webpage'); 
	var $helpers = array('Session', 'Html', 'Text', 'Form', 'Ajax', 'Javascript', 'Menu', 'Promo', 'Time', 'Login');
	var $components = array(/*'Acl', */'Auth', 'Session', 'RequestHandler', 'Email', 'RegisterCallbacks');
	var $view = 'Theme';
	var $userGroup = '';
/**
 * Fired early in the display process for defining app wide settings
 *
 * @todo 			Setup the condition check so that an APP constant turns it on and off.  A constant that gets turn on, when the first is_read condition is created.  It has a slight effect on performance so it should only be on if necessary.
 */
	function beforeFilter() {	
		# DO NOT DELETE #
		# commented out because for performance this should only be turned on if asked to be turned on
		# Start Condition Check #
		/*App::Import('Model', 'Condition');
		$this->Condition = new Condition;
		#get the id that was just inserted so you can call back on it.
		$conditions['plugin'] = $this->params['plugin'];
		$conditions['controller'] = $this->params['controller'];
		$conditions['action'] = $this->params['action'];
		$conditions['extra_values'] = $this->params['pass'];
		$this->Condition->checkAndFire('is_read', $conditions, $this->data); */
		# End Condition Check #
		# End DO NOT DELETE #
		
		
		#Configure::write('Config.language', 'eng');
		$this->viewPath = $this->_getLanguageViewFile();
		
	
/**
 * Allows us to have webroot files (css, js, etc) in the sites directories
 * Used in conjunction with the "var $view above"
 * @todo allow the use of multiple themes, database driven themes, and theme switching
 */
		$this->theme = 'default';
		
/**
 * Configure AuthComponent
*/
        $this->Auth->authorize = 'actions';
		
        $this->Auth->loginAction = array(
			'plugin' => null,
			'controller' => 'users',
			'action' => 'login'
			);
		
        $this->Auth->logoutRedirect = array(
			'plugin' => null,
			'controller' => 'users',
			'action' => 'login'
			);
        
        $this->Auth->loginRedirect = array(
			'plugin' => null,
			'controller' => 'users',
			'action' => 'view',
			'user_id' => $this->Session->read('Auth.User.id')
			);
		
		$this->Auth->actionPath = 'controllers/';
		# pulls in the hard coded allowed actions from the current controller
		$this->Auth->allowedActions = array('display');
		$this->Auth->authorize = 'controller';
		
/**
 * Support for json file types when using json extensions
 */
		$this->RequestHandler->setContent('json', 'text/x-json');
		
/**
 * @todo 	create this function, so that conditions can fire on the view of records
		$this->checkConditions($plugin, $controller, $action, $extraValues);
 */
		
		
/**
 * Used to show admin layout for admin pages
 */
		if(!empty($this->params['prefix']) && $this->params['prefix'] == 'admin' && $this->params['url']['ext'] != 'json' &&  $this->params['url']['ext'] != 'rss' && $this->params['url']['ext'] != 'xml' && $this->params['url']['ext'] != 'csv') {
			$this->layout = 'admin';
		}
		
/**
 * System wide settings are set here,
 * by gettting constants for app configuration
 */
		$this->__getConstants();
		
/**
 * Used to get database driven template
 */
		if (defined('__APP_DEFAULT_TEMPLATE_ID')) {
			$defaultTemplate = $this->Webpage->find('first', array('conditions' => array('id' => __APP_DEFAULT_TEMPLATE_ID)));
			$this->__parseIncludedPages ($defaultTemplate);
			$this->set(compact('defaultTemplate'));
		} else {
			echo 'In /admin/settings key: APP, value: DEFAULT_TEMPLATE_ID is not defined';
		}
		
/**
 * Implemented for allowing guests and creators ACL control
 */	
 		/* could not find where this is used so commented it out.  Delete if not used 12/3/2010 
 		$this->userGroup = $this->_getUserGroupAroId(); 
		$access = $this->_getUserGroupId();
		if (!empty($access['passed'])) {
			Configure::write('accessMessage', $access['message']);
			echo Configure::read('accessMessage');
			$this->Auth->allow('*');
		} else {
			$this->Session->setFlash($access['message']);
			$this->redirect(array('plugin' => null, 'controller' => 'users', 'action' => 'login'));
		}*/
	}
	
/**
 * This turns off debug so that ajax views don't get severly messed up
 * @todo convert to a full REST application and this might not be necessary
 */
    function beforeRender() {
		if($this->RequestHandler->isAjax()) { 
            Configure::write('debug', 0); 
        } else if ($this->RequestHandler->isXml()) {
            Configure::write('debug', 0); 
		} else if ($this->params['url']['ext'] == 'json') {
            #Configure::write('debug', 0); 
		}
		
	}
	
	
/** 
 * Database driven template system
 *
 * Using this function we can create pages within pages in the database
 * using structured tags (example : {include:pageid3}) 
 * which would include the database webpage with that id in place of the tag
 * @todo We need to fix up the {element: xyz_for_layout} so that you don't have to edit app_controller to have new helpers included, or somehow switch them all over to elements (the problem with that being that elements aren't as handy for data)
 */
	function __parseIncludedPages (&$webpage, $parents = array ()) {
		$matches = array ();
		$parents[] = $webpage["Webpage"]["id"];
		preg_match_all ("/(\{([^\}\{]*)include([^\}\{]*):([^\}\{]*)pageid([0-9]+)([^\}\{]*)\})/", $webpage["Webpage"]["content"], $matches);
		
		for ($i = 0; $i < sizeof ($matches[5]); $i++) {
			if (in_array ($matches[5][$i], $parents)) {
				$webpage["Webpage"]["content"] = str_replace ($matches[0][$i], "", $webpage["Webpage"]["content"]);
				continue;
			}
			$webpage2 = $this->Webpage->find("first", array("conditions" => array( "id" => $matches[5][$i]) ) );		
			if(empty($webpage2) || !is_array($webpage2)) continue;
			$this->__parseIncludedPages ($webpage2, $parents);
			$webpage["Webpage"]["content"] = str_replace ($matches[0][$i], $webpage2["Webpage"]["content"], $webpage["Webpage"]["content"]);
		}
	}
	
/** 
 * Settings for the site
 *
 * This is where we call all of the data in the "settings" table and parse
 * them into constants to be used through out the site.
 */	
	function __getConstants(){
		//Fetching All params
	   	$settings_array = $this->Setting->find('all');
	   	foreach($settings_array as $key => $value){
			$constant = "__".$value['Setting']['key'];
		  	# this gives you a blank value on the end, but I don't think it matters
		  	$pairs = explode(';', $value['Setting']['value']);
		  	foreach ($pairs as $splits) {
				$split = explode(':', $splits); 
			  	if(!defined($constant.'_'.$split[0]) && !empty($split[0])){
					define($constant.'_'.$split[0], $split[1]);
			  	}
			}
		}
	   # an example constant
	   # echo __APP_DEFAULT_TEMPLATE_ID;
	}
	
/** Mail functions
 * 
 * These next two functions are used primarily in the notifications plugin
 * but can be used in any plugin that needs to send email
 * @todo Alot more documentation on the notifications subject
 */	
	function __send_mail($id, $subject = null, $message = null, $template = null) {
		# example call :  $this->__send_mail(array('contact' => array(1, 2), 'user' => array(1, 2)));
		if (is_array($id)) : 
			if (is_array($id['contact'])): 
				foreach ($id['contact'] as $contact_id) : 
					$this->__send($contact_id, $subject, $message, $template);
				endforeach;
			endif;
			if (is_array($id['user'])): 
				foreach ($id['user'] as $user_id) : 
					App::import('Model', 'User');
					$this->User = new User();	
					$User = $this->User->read(null, $user_id);
					$contact_id = $User['User']['contact_id'];
					$this->__send($contact_id, $subject, $message, $template);
				endforeach;
			endif;
		else :
			$this->Session->setFlash(__('Notification ID Invalid', true));
		endif;
    } 
	
			
	function __send($id, $subject, $message, $template) {
		#$this->Email->delivery = 'debug';
		
		App::import('Model', 'Contact');
		$this->Contact = new Contact();	
		$Contact = $this->Contact->read(null,$id);
    	$this->Email->to = $Contact['Contact']['primary_email'];
   		$this->Email->bcc = array('slickricky+secret@gmail.com');  
    	$this->Email->subject = $subject;
	    $this->Email->replyTo = 'noreply@razorit.com';
	    $this->Email->from = 'noreply@razorit.com';
	    $this->Email->template = $template; 
	    $this->Email->sendAs = 'both'; 
	    $this->set('message', $message);
	    $this->Email->send();
		$this->Email->reset();
		
		#pr($this->Session->read('Message.email'));
		#die;
	}
	
	
	
	
/**
 * Convenience admin_add 
 * The goal is to make less code necessary in individual controllers 
 * and have more reusable code.
 */
	function __admin_add() {
		$model = Inflector::camelize(Inflector::singularize($this->params['controller']));
		if (!empty($this->data)) {
			$this->$model->create();
			if ($this->$model->save($this->data)) {
				$this->Session->setFlash(__('Saved.', true));
				$this->redirect($this->referer());
			} else {
				$this->Session->setFlash(__('Could not be saved', true));
			}
		}
	}
	
	
/**
 * Convenience admin_ajax_edit 
 * The goal is to make less code necessary in individual controllers 
 * and have more reusable code.
 */
	function __admin_ajax_edit($id = null) {
        if ($this->data) {
			# This will not work for multiple fields, and is meant for a form with a single value to update
			# Create the model name from the controller requested in the url
			$model = Inflector::camelize(Inflector::singularize($this->params['controller']));
			# These apparently aren't necessary. Left for reference.
			//App::import('Model', $model);
			//$this->$model = new $model();
			# Working to determine if there is a sub model needed, for proper display of updated info
			# For example Project->ProjectStatusType, this is typically denoted by if the field name has _id in it, becuase that means it probably refers to another database table.
			foreach ($this->data[$model] as $key => $value) {
				# weeding out if the form data is id, because id is standard
			    if($key != 'id') {
					# we need to refer back to the actual field name ie. project_status_type_id
					$fieldName = $key;
					# if the data from the form has a field name with _id in it.  ie. project_status_type_id
					if (strpos($key, '_id')) {
						$submodel = Inflector::camelize(str_replace('_id', '', $key));
						# These apparently aren't necessary. Left for reference.
						//App::import('Model', $submodel);
						//$this->$submodel = new $submodel();
					}
				}
			}
			
            $this->$model->id = $this->data[$model]['id'];
			$fieldValue = $this->data[$model][$fieldName];
			
			# save the data here
        	if ($this->$model->saveField($fieldName, $fieldValue, true)) { 
				# if a submodel is needed this is where we use it
				if (!empty($submodel)) {
					# get the default display field otherwise leave as the standard 'name' field
					if (!empty($this->$model->$submodel->displayField)){					
		                $displayField = $this->$model->$submodel->displayField; 
		            } else {
		                $displayField = 'name';
		            }
					echo $this->$model->$submodel->field($displayField, array('id' => $fieldValue));
					# we should have this echo statement sent to a view file for proper mvc structure. Left for reference
					//$this->set('displayValue', $displayValue);
				} else {
					echo $fieldValue;
					# we should have this echo statement sent to a view file for proper mvc structure. Left for reference
					//$this->set('displayValue', $displayValue);
				}
			# not sure that this would spit anything out.
			} else {
				$this->set('error', true);
				echo $error;
			}
		}
		$this->render(false);
	}	
	
	
	
/**
 * Convenience admin_delete
 * The goal is to make less code necessary in individual controllers 
 * and have more reusable code.
 * @param int $id
 * @todo Not entirely sure we need to use import for this, and if that isn't a security problem. We need to check and confirm.
 */
	function __admin_delete($id=null) {
		$model = Inflector::camelize(Inflector::singularize($this->params['controller']));
		App::import('Model', $model);
		$this->$model = new $model();
		// set default class & message for setFlash
		$class = 'flash_bad';
		$msg   = 'Invalid List Id';
		
		// check id is valid
		if($id!=null && is_numeric($id)) {
			// get the Item
			$item = $this->$model->read(null,$id);
			
			// check Item is valid
			if(!empty($item)) {
				// try deleting the item
				if($this->$model->delete($id)) {
					$class = 'flash_good';
					$msg   = 'Successfully deleted';
				} else {
					$msg = 'There was a problem deleting your Item, please try again';
				}
			}
		}
	
		// output JSON on AJAX request
		if($this->RequestHandler->isAjax()) {
			$this->autoRender = $this->layout = false;
			echo json_encode(array('success'=>($class=='flash_bad') ? FALSE : TRUE,'msg'=>"<p id='flashMessage' class='{$class}'>{$msg}</p>"));
		exit;
		}
	
		// set flash message & redirect
		$this->Session->setFlash(__($msg, true));
		$this->redirect(Controller::referer());
	}
	
	
/**
 * Convenience Ajax List Method (Fill Select Drop Downs) for Editable Fields
 * The goal is to make less code necessary in individual controllers 
 * and have more reusable code.
 * 
 * @return a filled <select> with <options>
 */
    function __ajax_list($id = null){	
		# get the model from the controller being requested
		$model = Inflector::camelize(Inflector::singularize($this->params['controller']));
		# check for empty values and set them to null
		foreach ($this->params['named'] as $key => $value ) {
			if(empty($this->params['named'][$key])) {
				$this->params['named'][$key] = null;
			}
		}
		# set the conditions by the named parameters - ex. project_id:1
		$conditions = am($this->params['named']);
		#find the list with given parameter conditions
    	$list =  $this->$model->find('list', array('conditions' => $conditions));
		#display the drop down
		$this->str = '<option value="">-- Select --</option>';
        foreach ($list as $key => $value){
            $this->str .= "<option value=".$key.">".$value."</option>";
        }		
		if ($this->params['url']['ext'] == 'json') {
			echo '{';
			foreach ($list as $key => $value) {
				echo '"'.$key.'":"'.$value.'",';
			}			
			echo '}';
			$this->render(false);
		} else {
        	$this->set('data', $this->str);  
			$list = $this->str;
			echo $list;
			$this->render(false);
		}		
    }
	
	
	function _getLanguageViewFile() {
		$locale = Configure::read('Config.language');
		if ($locale && !empty($this->params['plugin'])) {
			// put plugin view path here
			$localViewFile = APP.'views'.DS.'locale'.DS.$locale . DS . 'plugins' . DS . $this->params['plugin'] . DS . $this->viewPath . DS . $this->params['action'] . '.ctp';
			$localPluginViewFile = APP.'plugins'.DS.$this->params['plugin'].DS.'views'.DS.'locale'.DS.$locale.DS.$this->viewPath . DS . $this->params['action'] . '.ctp';
			if (file_exists($localViewFile)) {
				$this->viewPath = 'locale'.DS.$locale.DS.'plugins'.DS.$this->params['plugin'].DS.$this->viewPath;
			} else if (file_exists($localPluginViewFile)) {
				$this->viewPath = 'locale'.DS.$locale.DS.$this->viewPath;			
			}

		} else if ($locale) {
			// put non-plugin view path here
			$localViewFile = APP.DS.'views'.DS.'locale'.DS.$locale.DS.$this->viewPath.DS.$this->params['action'].'.ctp';
			if (file_exists($localViewFile)) {
				$this->viewPath = 'locale'.DS.$locale.DS.$this->viewPath;
			}
		} 
		return $this->viewPath;
	}
	
	
/**
 * Build ACL is a function used for updating the acos table with all available plugins and controller methods.
 * 
 * Was extended to make it possible to do a single controller or plugin at a time, instead of a full rebuild.
 * @todo We need to add default index, view, add, edit, delete, admin_index, admin_view, admin_add, admin_edit, admin_delete functions, if we can figure out a way so that particular controllers can turn them off, and keep the build_acl stuff below knowledgeable of it, so that acos stay clean. 
 * @link http://book.cakephp.org/view/648/Setting-up-permissions
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

	
#################  HERE DOWN IS PERMISSIONS ##################	


/**
 * Access control upgrade
 * It should fire only if the user does not have 
 * access to the current page and if they don't 
 * see if they have creator access.
 */
	function isAuthorized() {		
		$userId = $this->Auth->user('id');
		# check guest access
		$aro = $this->_guestsAro(); // guest aro model and foreign_key
		$aco = $this->_actionAco(); // get controller and action 
		if ($this->checkAccess($aro, $aco)) {
			echo 'guest access passed';
			#return array('passed' => 1, 'message' => 'guest access passed');
			return true;
		} else if (!empty($userId)) {
			# check user access
			$aro = $this->_userAro($userId); // guest aro model and foreign_key
			$aco = $this->_actionAco(); // get controller and action 
			if ($this->checkAccess($aro, $aco)) {
				echo 'user access passed';
				#return array('passed' => 1, 'message' => 'user access passed');
				return true;
			} else {
				# check user access
				$aro = $this->_userAro($userId); // guest aro model and foreign_key
				$aco = $this->_recordAco(); // get controller and action 
				if ($this->checkAccess($aro, $aco)) {
					echo 'record level access passed';
					#return array('passed' => 1, 'message' => 'record level access passed');
					return true;
				} else {
					echo ' all three checks failed';
					#return array('message' => 'You are logged in, but access is denied for your user.');
					$this->Session->setFlash(__('You are logged in, but access is denied for your user.', true));
					$this->redirect(array('controller' => 'users', 'action' => 'login'));
				}
			}	
		} else {
			$this->Session->setFlash(__('Guests access not allowed, please login.', true));
			$this->redirect(array('controller' => 'users', 'action' => 'login'));
		}
		
		/*
		pr($this->Auth->isAuthorized());
		echo '<hr>';
		#break;
		$userId = $this->Auth->user('id');
		# this needs another version which gets the record level aco if it exists, and if not get the 
		$aco = $this->{$this->modelClass}->getAco($this->params , true);
		# check if the function is already allowed by hard coding in the controller
		if (!in_array($this->params['action'], $this->Auth->allowedActions) && property_exists($this, 'Acl')) {
			# if the user is logged in we need to check for creator and guest access
			# if they are not logged in, then we only need to check for creator access
			# removed an if here !$this->Auth->isAuthorized() from this if because it does 7 extra db calls (12/3/2010)
			# check if node has guest access 
			$AroAco = $this->_guestsAroAco();
			if(!$this->Acl->check($AroAco['aro'], $AroAco['aco'])) {
				# check if node has record level access
				$AroAco = $this->_recordAroAco($userId);
				if (!empty($userId) && $this->Acl->check($AroAco['aro'], $AroAco['aco'])) {
					echo 'third access check';
					return true;
				} else {
					echo 'all three checks failed';
					return false;
				}
			} else {
				echo 'second access check';
				# guest acccess went through
				return true;
			} 
		} else {
			// action is allowed directly from the actual controller (hard coded)
			echo 'hard coded access';
			return true;
		}*/
	}
	
/**
 * guestsAco = string ex. Tickets/index
 * this could be the full path of the aco, but it is a slightly slower query
 * $this->Acl->check($guestsAro, 'controllers/Tickets/Tickets/index') 
 */
	function _actionAco() {
		//if (defined('__SYS_GUESTS_USER_GROUP_ID')) {
		if (defined('__SYS_GUESTS_GROUP_ARO_ID')) {
			#$guestsAco = Inflector::camelize($this->params['controller']).'/'.$this->params['action']; 
			$guestsAco['controller'] = Inflector::camelize($this->params['controller']);
			$guestsAco['action'] = $this->params['action'];
		} else {
			echo 'In /admin/settings key: SYS, value: GUESTS_GROUP_ARO_ID must be defined for guest access to work.';
		}
		return $guestsAco;
	}
	
/**
 * guestsAco = string ex. Tickets/index
 * this could be the full path of the aco, but it is a slightly slower query
 * $this->Acl->check($guestsAro, 'controllers/Tickets/Tickets/index') 
 */
	function _userAro($userId) {
		$guestsAro = array('model' => 'User', 'foreign_key' => $userId);
		return $guestsAro;
	}
	
/**
 * guestsAco = string ex. Tickets/index
 * this could be the full path of the aco, but it is a slightly slower query
 * $this->Acl->check($guestsAro, 'controllers/Tickets/Tickets/index') 
 */
	function _guestsAro() {
		//if (defined('__SYS_GUESTS_USER_GROUP_ID')) {
		if (defined('__SYS_GUESTS_GROUP_ARO_ID')) {
			# IMPORTTANT THIS NEEDS TO BE UPDATED TO THE USER GROUP ID THAT THE CURRENT USER IS IN
			# OR TO THE GUEST USER GROUP
			$guestsAro = array('model' => 'UserGroup', 'foreign_key' => 5);
		} else {
			echo 'In /admin/settings key: SYS, value: GUESTS_GROUP_ARO_ID must be defined for guest access to work.';
		}
		return $guestsAro;
	}
	
/**
 * guestsAco = string ex. Tickets/index
 * this could be the full path of the aco, but it is a slightly slower query
 * $this->Acl->check($guestsAro, 'controllers/Tickets/Tickets/index') 
 */
	function _guestsAroAco() {
		//if (defined('__SYS_GUESTS_USER_GROUP_ID')) {
		if (defined('__SYS_GUESTS_GROUP_ARO_ID')) {
			$guestsAro = array('model' => 'UserGroup', 'foreign_key' => 5);
			#$guestsAco = Inflector::camelize($this->params['controller']).'/'.$this->params['action']; 
			$guestsAco['controller'] = Inflector::camelize($this->params['controller']);
			$guestsAco['action'] = $this->params['action'];
		} else {
			echo 'In /admin/settings key: SYS, value: GUESTS_GROUP_ARO_ID must be defined for guest access to work.';
		}
		return array('aro' => $guestsAro, 'aco' => $guestsAco);
	}
	
	
/**
 * Gets the recordLevel Aro and Aco nodes
 */
	function _recordAco() {
		if(!empty($this->params['pass'][0])) {
			$recordAco = array(
				'model' => Inflector::classify($this->params['controller']), 
				'foreign_key' => $this->params['pass'][0],
				);
			return $recordAco;
		} else {
			return null;
		}
	}
	
	
/**
 * Gets the recordLevel Aro and Aco nodes
 */
	function _recordAroAco($userId) {
		if(!empty($this->params['pass'][0])) {
			$recordAro = array('model' => 'User', 'foreign_key' => $userId);
			$recordAco = array(
				'model' => Inflector::classify($this->params['controller']), 
				'foreign_key' => $this->params['pass'][0],
				);
			return array('aro' => $recordAro, 'aco' => $recordAco);
		} else {
			return null;
		}
	}
    
/**
 * gets user group for acl check 
 */
    function _getUserGroupAroId(){
    	#get users group
		if($this->Auth->user('id') != 0){
			$userModel = ClassRegistry::init('User');
			# $userModel->recursive = 1 ;  // commented for non-use 11/2010, remove if no errors show because of it.
			# this gets the user group id of the user
			$uData = $userModel->find('first' , array(
				'conditions' => array('User.id'=>$this->Auth->user('id')),
				'contain' => array(
					'UserGroup' => array(
						'fields' => array(
							'id',
							'name'
						)
					)
				)
				
			));
			
			$permAro = ClassRegistry::init('Permissions.Arore');
			$permAro->recursive = 0;
			# this returns the aro id for the user group this user belongs to 
			$arDat = $permAro->find('first' , array(
					'conditions'=>array(
							'Arore.foreign_key'=>$uData['UserGroup']['id']
					), 
					'contain'=>array(),
					'fields'=>array('id')
			));
			return $arDat["Arore"]["id"];
		}
    }
    
/**
 * Used to do a double check on the aro id, for record level, and guest level access.
 * @param {int} userGroup -> The aro_id of the userGroup 
 * @todo add guest functionality here with a param 
 * @return {bool}
 */   
    function _checkAccess($aroId , $params){
    	$arac = ClassRegistry::init("Permissions.ArosAco");
		$cn = $arac->find('first' , array(
      		'conditions'=>array(
	      		'ArosAco.aro_id' => $aroId,
	   			/* this was changed to false to get individual records to work (not sure what other effects it will have)*/
			  	'ArosAco.aco_id' => $this->{$this->modelClass}->getAco($params , true)
	   			/* this was changed to true to get individual action to work (not sure what other effects it will have)
	      		'ArosAco.aco_id' => $this->{$this->modelClass}->get_aco($params , false)*/
	      		),
	      	'contain'=>array(),
	      	/*'fields'=>array(
	       		'_create',
	      		)*/
     	));
    	if(!empty($cn)){
			if($cn["ArosAco"]["_create"] == 1 ){
       			return true;
      		} else {
       			return false; 
      		} 
     	} else {
      		return false;
     	} 
	}
	
 
}
?>
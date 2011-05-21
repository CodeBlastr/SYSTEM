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
 * Copyright 2009-2010, Zuha Foundation Inc. (http://zuha.org)
 *
 * Licensed under GPL v3 License
 * Must retain the above copyright notice and release modifications publicly.
 *
 * @copyright     Copyright 2009-2010, Zuha Foundation Inc. (http://zuha.com)
 * @link          http://zuha.com Zuha� Project
 * @package       zuha
 * @subpackage    zuha.app
 * @since         Zuha(tm) v 0.0.1
 * @license       GPL v3 License (http://www.gnu.org/licenses/gpl.html) and Future Versions
 */
//Note : Enable CURL PHP in php.ini file to use Facebook.Connect component of facebook plugin: Faheem
class AppController extends Controller {
	
	var $userId = '';
    var $uses = array('Condition', 'Webpages.Webpage');
	var $helpers = array('Session', 'Text', 'Form', 'Js', 'Time');
	var $components = array('Acl', 'Auth', 'Session', 'RequestHandler', 'Email', 'RegisterCallbacks', 'SwiftMailer');
	var $view = 'Theme';
	var $userRoleId = __SYSTEM_GUESTS_USER_ROLE_ID;
	var $params = array();
	
	function __construct(){
		$this->helpers['Html'] =  array('aro' => 'alsdkfjasd'/*$this->_guestsAro()*/);
		parent::__construct();
		$this->_getHelpers();
		$this->_getComponents();
	}
	
	
	/**
	 * Handles the variables and functions that fire before all other controllers
	 * 
	 * @todo		There is a problem with the acl check, when using a site wide template tag for an element which is not allowed.  It redirects you to the login page like it should, but the login page also has that template tag, so it is an infinite loop that is hard to debug. 
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
		$this->viewPath = $this->_getView();
		
	
		/**
 		 * Allows us to have webroot files (css, js, etc) in the sites directories
 		 * Used in conjunction with the "var $view above"
		 * @todo allow the use of multiple themes, database driven themes, and theme switching
 		 */
		$this->theme = 'default';
		
		
		/**
		 * Configure AuthComponent
		 */
		$authError = defined('__APP_DEFAULT_LOGIN_ERROR_MESSAGE') ? unserialize(__APP_DEFAULT_LOGIN_ERROR_MESSAGE) : array('message'=> 'Please register or login to access that feature.');
		$this->Auth->authError = $authError['message'];
        $this->Auth->loginAction = array(
			'plugin' => 'users',
			'controller' => 'users',
			'action' => 'login'
			);
		
        $this->Auth->logoutRedirect = array(
			'plugin' => 'users',
			'controller' => 'users',
			'action' => 'login'
			);
        
        $this->Auth->loginRedirect = $this->_defaultLoginRedirect();

		$this->Auth->actionPath = 'controllers/';
		# pulls in the hard coded allowed actions from the current controller
		$this->Auth->allowedActions = array('display');
		$this->Auth->authorize = 'controller';
		if (!empty($this->allowedActions)) {
			$allowedActions = array_merge($this->Auth->allowedActions, $this->allowedActions);
			$this->Auth->allowedActions = $allowedActions;
		}
		
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
		
		# system wide settings
 		if (empty($this->params['requested'])) { $this->_getTemplate(); }
		
		/**
		 * Implemented for allowing guests access through db acl control
		 */ #$this->Auth->allow('*');
		$this->userId = $this->Auth->user('id');
		$allowed = array_search($this->params['action'], $this->Auth->allowedActions);
		if ($allowed === 0 || $allowed > 0 ) {
			$this->Auth->allow('*');
		} else if (empty($this->userId) && empty($allowed)) {
			$aro = $this->_guestsAro(); // guests group aro model and foreign_key
			$aco = $this->_getAcoPath(); // get controller and action 
			# this first one checks record level if record level exists
			# which it can exist and guests could still have access 
			if ($this->Acl->check($aro, $aco)) {
				$this->Auth->allow('*');
			}
		} 
		
		$this->userRoleId = $this->Session->read('Auth.User.user_role_id');
		$this->userRoleId = !empty($this->userRoleId) ? $this->userRoleId : __SYSTEM_GUESTS_USER_ROLE_ID;
		# this seems to break the login (left for reference 3/9/2011) delete if its a month old
		#$this->Session->write('Auth.User.user_role_id', $this->userRoleId);
	}
	
	
	/**
	 * @todo convert to a full REST application and this might not be necessary
	 */
    function beforeRender() {  
		# this needed to be duplicated from the beforeFilter 
		# because beforeFilter doesn't fire on error pages.
		if($this->name == 'CakeError') {
	 		$this->_getTemplate();
	    }  		
		# This turns off debug so that ajax views don't get severly messed up
		if($this->RequestHandler->isAjax()) { 
            Configure::write('debug', 0); 
        } else if ($this->RequestHandler->isXml()) {
			$this->header('Content-Type: text/xml');
		} else if ($this->params['url']['ext'] == 'json') {
            Configure::write('debug', 0); 
		}
	}
	
	
	/**
	 * Set the default redirect variables, using the settings table constant.
	 */
	function _defaultLoginRedirect() {
		if (defined('__APP_DEFAULT_LOGIN_REDIRECT_URL')) {
			if ($urlParams = @unserialize(__APP_DEFAULT_LOGIN_REDIRECT_URL)) {
				return $urlParams;
			} else {
				return __APP_DEFAULT_LOGIN_REDIRECT_URL;
			}
		} else {
			return array(
				'plugin' => 'users',
				'controller' => 'users',
				'action' => 'my',
			);
		}
	}
	
	
	/** 
	 * Database driven template system
	 *
	 * Using this function we can create pages within pages in the database
	 * using structured tags (example : {include:pageid3}) 
	 * which would include the database webpage with that id in place of the tag
	 * @todo wasn't sure if this was the right place, but we should pull all of the webpage records in one call instead of multiple if we can, and cache them for performance.
	 */
	function __parseIncludedPages (&$webpage, $parents = array ()) {
		$matches = array ();
		$parents[] = $webpage["Webpage"]["id"];
		preg_match_all ("/(\{page:([^\}\{]*)([0-9]*)([^\}\{]*)\})/", $webpage["Webpage"]["content"], $matches);
		
		for ($i = 0; $i < sizeof ($matches[2]); $i++) {
			if (in_array ($matches[2][$i], $parents)) {
				$webpage["Webpage"]["content"] = str_replace ($matches[0][$i], "", $webpage["Webpage"]["content"]);
				continue;
			}
			$webpage2 = $this->Webpage->find("first", array("conditions" => array( "id" => $matches[2][$i]) ) );		
			if(empty($webpage2) || !is_array($webpage2)) continue;
			$this->__parseIncludedPages ($webpage2, $parents);
			$webpage["Webpage"]["content"] = str_replace ($matches[0][$i], $webpage2["Webpage"]["content"], $webpage["Webpage"]["content"]);
		}
	}
	
/** Mail functions
 * 
 * These next two functions are used primarily in the notifications plugin
 * but can be used in any plugin that needs to send email
 * @todo Alot more documentation on the notifications subject
 */	
	function __send_mail($id, $subject = null, $message = null, $template = null, $attachment = null) {
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
	
			
	function __send($id, $subject, $message, $template, $attachment = null) {
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
	

/**
 * This function handles view files, and the numerous cases of layered views that are possible. Used in reverse order, so that you can over write files without disturbing the default view files. 
 * Case 1 : No view file exists (default), so try using the scaffold file. (this means we can have default reusable views)
 * Case 2 : Standard view file exists (second check), so use it.  (ie. cakephp standard paths)
 * Case 3 : Language or Local view files (first check).  Views which are within the multi-site directories.  To use, you must set a language configuration, even if its just the default "en". 
 *
 * @return {string}		The viewPath variable
 * @todo 				Move these next few functions to a component.
 */
	function _getView() {
		/* order should be 
		1. complete localized plugin or view folder with extension (not html)
		2. localized language plugin or view folder with extension (not html)
		3. root app directory plugin or view folder with extension (not html)
		4. scaffolded directory for this action with extension (not html) */
		$possibleLocations = array(
			# 0 app (including sites) /plugins/wikis/views/locale/eng/wiki_categories/view.ctp
			APP.$this->_getPlugin(false, true).'views'.$this->_getLocale().DS.$this->viewPath.$this->_getExtension().DS.$this->params['action'].'.ctp',
			# 1 app (including sites) /plugins/wikis/views/wiki_categories/view.ctp
			APP.$this->_getPlugin(false, true).'views'.DS.$this->viewPath.$this->_getExtension().DS.$this->params['action'].'.ctp',
			# 2 app (including sites) /views/locale/eng/plugins/projects/projects/index.ctp
			APP.'views'.$this->_getLocale(true).$this->_getPlugin(true, true).$this->viewPath.$this->_getExtension().DS.$this->params['action'].'.ctp',
			# 3 root app only /views/locale/eng/plugins/wikis/wikis/index.ctp
			ROOT.DS.'app'.DS.'views'.$this->_getLocale(true).$this->_getPlugin(true, false).DS.$this->viewPath.$this->_getExtension().DS.$this->params['action'].'.ctp',	
			# 4 root app only /plugins/wikis/views/locale/eng/wikis/index.ctp
			ROOT.DS.'app'.$this->_getPlugin(true, false).DS.'views'.$this->_getLocale(true).DS.$this->viewPath.$this->_getExtension().DS.$this->params['action'].'.ctp',
			# 5 root app only /plugins/wikis/views/wikis/json/index.ctp
			ROOT.DS.'app'.$this->_getPlugin(true, false).DS.'views'.DS.$this->viewPath.$this->_getExtension().DS.$this->params['action'].'.ctp',
			# 6 root app only /views/scaffolds/json/view.ctp
			ROOT.DS.'app'.DS.'views'.DS.'scaffolds'.$this->_getExtension().DS.$this->params['action'].'.ctp',		
			);
		$matchingViewPaths = array(
			$this->_getLocale(true).DS.$this->viewPath, // 0 checked
			$this->viewPath, // 1 checked
			$this->_getLocale(true).$this->_getPlugin(true, true).$this->viewPath, // 2 checked
			$this->_getLocale(true).$this->_getPlugin(true, true).$this->viewPath, // 3  checked, checked
			$this->_getLocale(true, true).$this->viewPath, // 4 checked, checked
			$this->viewPath, // 5 checked
			'scaffolds', // 6 checked
			);
		foreach ($possibleLocations as $key => $location) {
			if (file_exists($location)) {
				return $this->viewPath = $matchingViewPaths[$key];
				break;
			}
		}
	}
	
	function _checkViewFiles() {
	}
	
	function _getExtension() {
		 if (!empty($this->params['url']['ext']) && $this->params['url']['ext'] != 'html') {
			 # returns /json or /xml or /rss
			 return DS.$this->params['url']['ext']; 
		 } else {
			 return null;
		 }
	}
	
	function _getLocale($startingDS = false, $trailingDS = false) {
		$locale = Configure::read('Config.language');
		if (!empty($locale)) {
			# returns /locale/eng or /locale/fr etc.
			$path = (!empty($startingDS) ? DS : '');
			$path .= 'locale'.DS.$locale;
			$path .= (!empty($trailingDS) ? DS : '');
			return $path;
		} else {
			return null;
		}
	}
	
	function _getPlugin($startingDS = false, $trailingDS = false) {
		if (!empty($this->params['plugin'])) {
			# returns plugins/orders OR plugins/projects (no starting slash because its in the APP constant)
			$path = (!empty($startingDS) ? DS : '');
			$path .= 'plugins'.DS.$this->params['plugin'];
			$path .= (!empty($trailingDS) ? DS : '');
			return $path;
		} else {
			return null;
		}
	}
	
	
	/**
	 * Used to find the template parsing.  Sets the defaultTemplate variable for the layout.
	 *
	 */
	function _getTemplate() {
        if (defined('__APP_DEFAULT_TEMPLATE_ID')) {
            $template_id = __APP_DEFAULT_TEMPLATE_ID;
            if (defined('__APP_MULTI_TEMPLATE_IDS')) {
				if(is_array(unserialize(__APP_MULTI_TEMPLATE_IDS))) {
					extract(unserialize(__APP_MULTI_TEMPLATE_IDS));
				}
				$i = 0;
				if (!empty($url)) { foreach($url as $u) {
					# check each one against the current url
					$u = str_replace('/', '\/', $u);
					$urlRegEx = '/'.str_replace('*', '(.*)', $u).'/';
					if (preg_match($urlRegEx, $this->params['url']['url'])) {
						$template_id = $templateId[$i];
					}
					$i++;
				}}
	
				if (!empty($webpages)) { foreach ($webpages as $webpage) {
					echo $webpage['Webpage']['content'];
				}} else {
					# echo 'do nothing, use default template';
				}
            }
            $defaultTemplate = $this->Webpage->find('first', array('conditions' => array('id' => $template_id)));
            $this->__parseIncludedPages($defaultTemplate);
            $this->set(compact('defaultTemplate'));
        } else {
			echo 'In /admin/settings key: APP, value: DEFAULT_TEMPLATE_ID is not defined';
		}
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
		
	
	/**
	 * Loads helpers dynamically system wide, and per controller loading abilities.
	 *
	 */
	function _getHelpers() {
		if(defined('__APP_LOAD_APP_HELPERS')) {
			$settings = __APP_LOAD_APP_HELPERS;
			if ($helpers = @unserialize($settings)) {
				foreach ($helpers as $key => $value) {
					if ($key == 'helpers') {
						foreach ($value as $val) {
							$this->helpers[] = $val;
						}
					} else if ($key == $this->name) {
						if (is_array($value)) {
							foreach ($value as $val) {
								$this->helpers[] = $val;
							}
						} else {
							$this->helpers[] = $value;
						}							
					}
				}
			} else {
				$this->helpers = array_merge($this->helpers, explode(',', $settings));
			}
		}
	}
	
	
	/**
	 * Loads components dynamically using both system wide, and per controller loading abilities.
	 *
	 * You can create a comma separated (no spaces) list if you only need a system wide component.  If you would like to specify components on a per controller basis, then you use ControllerName[] = Plugin.Component. (ie. Projects[] = Ratings.Ratings).  If you want both per controller, and system wide, then use the key components[] = Plugin.Component for each system wide component to load.  Note: You cannot have a comma separated list, and the named list at the same time. 
	 */
	function _getComponents() {
		if(defined('__APP_LOAD_APP_COMPONENTS')) {
			$settings = __APP_LOAD_APP_COMPONENTS;
			if ($components = @unserialize($settings)) {
				foreach ($components as $key => $value) {
					if ($key == 'components') {
						foreach ($value as $val) {
							$this->components[] = $val;
						}
					} else if ($key == $this->name) {
						if (is_array($value)) {
							foreach ($value as $val) {
								$this->components[] = $val;
							}
						} else {
							$this->components[] = $value;
						}
					}
				}
			} else {
				$this->components = array_merge($this->components, explode(',', $settings));
			}
		}
	}


	/**
	 * sendMail
	 *
	 * Send the mail to the user.
	 * $email: Array - address/name pairs (e.g.: array(example@address.com => name, ...)
	 * 		String - address to send email to
	 * $subject: subject of email.
	 * $template to be picked from folder for email. By default, if $mail is given in any template, especially default, 
	 * $message['html'] in the layout will be replaced with this text. 
	 * Else modify the template from the view file and set the variables from action via $this->set
	 */
	function __sendMail($email = null, $subject = null, $mail = null, $template = 'default') {
		$this->SwiftMailer->to = $email;
		// @todo: replace configure with settings.ini pick
		$this->SwiftMailer->from = 'noreply@razorit.com';
		$this->SwiftMailer->fromName = 'noreply@razorit.com';
		$this->SwiftMailer->template = $template;

		$this->SwiftMailer->layout = 'email';
		$this->SwiftMailer->sendAs = 'html';

		if ($mail) {
			$this->SwiftMailer->content = $mail;
			$message['html'] = $mail; 
			$this->set('message', $message);
		}
		
		if (!$subject)
			$subject = 'No Subject';

		//Set view variables as normal
		return $this->SwiftMailer->send($template, $subject);
   }
		
		
##############################################################
##############################################################
#################  HERE DOWN IS PERMISSIONS ##################
##############################################################
##############################################################
##############################################################
##############################################################
##############################################################


	/**
	 * This function is called by $this->Auth->authorize('controller') and only fires when the user is logged in. 
	 */
	function isAuthorized() {	
		# this allows all users in the administrators group access to everything
		if ($this->userRoleId == 1) { return true; } 
		# check guest access
		$aro = $this->_guestsAro(); // guest aro model and foreign_key
		$aco = $this->_getAcoPath(); // get aco
		if ($this->Acl->check($aro, $aco)) {
			#echo 'guest access passed';
			#return array('passed' => 1, 'message' => 'guest access passed');
			return true;
		} else {
			# check user access
			$aro = $this->_userAro($this->userId); // user aro model and foreign_key
			$aco = $this->_getAcoPath(); // get aco
			if ($this->Acl->check($aro, $aco)) {
				#echo 'user access passed';
				#return array('passed' => 1, 'message' => 'user access passed');
				return true;
			} else {
				#debug($aro);
				#debug($aco);
				#break;
				$this->Session->setFlash(__('You are logged in, but all access checks have failed.', true));
				$this->redirect(array('plugin' => 'users', 'controller' => 'users', 'action' => 'login'));
			}	
		} 
	}
	
	/**
	 * Gets the variables used to lookup the aco id for the action type of lookup
	 * VERY IMPORTANT : If the aco is a record level type of aco (ie. model and foreign_key lookup) that means that all groups and users who have access rights must be defined.  You cannot have negative values for access permissions, and thats okay, because we deny everything by default.
	 *
	 * return {array || string}		The path to the aco to look up.
	 */
	function _getAcoPath() {
		if (!empty($this->params['pass'][0])) {
			# check if the record level aco exists first
			$aco = $this->Acl->Aco->find('first', array(
				'conditions' => array(
					'model' => $this->modelClass, 
					'foreign_key' => $this->params['pass'][0]
					)
				));
		}
		if(!empty($aco)) {
			return array('model' => $this->modelClass, 'foreign_key' => $this->params['pass'][0]);
		} else {
			$controller = Inflector::camelize($this->params['controller']);
			$action = $this->params['action'];
			# $aco = 'controllers/Webpages/Webpages/view'; // you could do the full path, but the shorter path is slightly faster. But it does not allow name collisions. (the full path would allow name collisions, and be slightly slower). 
			return $controller.'/'.$action;
		}
	}
	
	
	/**
	 * Gets the variables used for the lookup of the aro id
	 */
	function _userAro($userId) {
		$guestsAro = array('model' => 'User', 'foreign_key' => $userId);
		return $guestsAro;
	}
	
	
	/**
	 * Gets the variables used for the lookup of the guest aro id
	 */
	function _guestsAro() {
		if (defined('__SYSTEM_GUESTS_USER_ROLE_ID')) {
			$guestsAro = array('model' => 'UserRole', 'foreign_key' => __SYSTEM_GUESTS_USER_ROLE_ID);
		} else {
			echo 'In /admin/settings key: SYS, value: GUESTS_USER_ROLE_ID must be defined for guest access to work.';
		}
		return $guestsAro;
	}
	
}
?>
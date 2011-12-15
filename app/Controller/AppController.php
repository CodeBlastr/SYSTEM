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
    var $uses = array('Condition');
	var $helpers = array('Session', 'Text', 'Form', 'Js', 'Time', 'Html');
	var $components = array('Acl', 'Auth', 'Session', 'RequestHandler', 'SwiftMailer', 'RegisterCallbacks' /*'RegisterCallbacks', 'SwiftMailer', 'Security' Desktop Login Stops Working When This is On*/);
	var $viewClass = 'Theme';
	var $theme = 'Default';
	var $userRoleId = __SYSTEM_GUESTS_USER_ROLE_ID;
	// update this so that it uses the full list of actual user roles
	var $userRoles = array('administrators', 'guests');
	var $userRoleName = 'guests';
	var $params = array();
	var $templateId = '';
	
	
	public function __construct($request = null, $response = null) {
		parent::__construct($request, $response);
		$this->_getHelpers();
		$this->_getComponents();
		$this->_getUses();
	}
	
	
/**
 * Over ride a controllers default redirect action by adding a form field which specifies the redirect.
 */
	function redirect($url, $status = null, $exit = true) {
		if (!empty($this->request->data['Success']['redirect']) && $status == 'success') :
			return parent::redirect($this->request->data['Success']['redirect'], $status, $exit);
		elseif (!empty($this->request->data['Error']['redirect']) && $status == 'error') :
			return parent::redirect($this->request->data['Error']['redirect'], $status, $exit);
		elseif (!empty($this->request->data['Override']['redirect'])) :
			return parent::redirect($this->request->data['Override']['redirect'], $status, $exit);	
		else : 
			return parent::redirect($url, $status, $exit);
		endif;
	}
	
	
	
	function beforeFilter() {
		# DO NOT DELETE #
		# commented out because for performance this should only be turned on if asked to be turned on
		# Start Condition Check #
		#App::Import('Model', 'Condition');
		#$this->Condition = new Condition;
		#get the id that was just inserted so you can call back on it.
		#$conditions['plugin'] = $this->request->params['plugin'];
		#$conditions['controller'] = $this->request->params['controller'];
		#$conditions['action'] = $this->request->params['action'];
		#$conditions['extra_values'] = $this->request->params['pass'];
		#$this->Condition->checkAndFire('is_read', $conditions, $this->request->data); */
		# End Condition Check #
		# End DO NOT DELETE #
		
		$this->_configAuth();
		
		
		/**
		 * Support for json file types when using json extensions
		 */
		$this->RequestHandler->setContent('json', 'text/x-json');
		
		/**
		 * @todo 	create this function, so that conditions can fire on the view of records
				$this->checkConditions($plugin, $controller, $action, $extraValues);
		 */
				
		/**
		 * Implemented for allowing guests access through db acl control
		 */ #$this->Auth->allow('*');
		$this->userId = $this->Auth->user('id');
		$allowed = array_search($this->request->params['action'], $this->Auth->allowedActions);
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
		
		/*
		 * Below here (in this function) are things that have to come after the final userRoleId is determined
		 */
		$this->userRoleId = $this->Session->read('Auth.User.user_role_id');
		$this->userRoleName = $this->Session->read('Auth.UserRole.name');
		$this->userRoleId = !empty($this->userRoleId) ? $this->userRoleId : __SYSTEM_GUESTS_USER_ROLE_ID;
		$this->userRoleName = !empty($this->userRoleName) ? $this->userRoleName : 'guests';
		
		#$this->_siteTemplate();
		
		/**
		 * Check whether the site is sync'd up 
		 */
		$this->_siteStatus();	
	}
	
	/**
	 * @todo convert to a full REST application and this might not be necessary
	 */
    function beforeRender() {		
		# This turns off debug so that ajax views don't get severly messed up
		if($this->RequestHandler->isAjax()) :
            Configure::write('debug', 0); 
		endif;
	}
	
	
	/**
	 * List plugins
	 */
	function _list_plugins() {
		$this->set('plugins', $this->listPlugins);
	}
	
	
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
	 * Convenience admin_add 
	 * The goal is to make less code necessary in individual controllers 
	 * and have more reusable code.
	 */
	function __admin_add() {
		$model = Inflector::camelize(Inflector::singularize($this->request->params['controller']));
		if (!empty($this->request->data)) {
			$this->$model->create();
			if ($this->$model->save($this->request->data)) {
				$this->Session->setFlash(__('Saved.', true));
				$this->redirect($this->referer());
			} else {
				$this->Session->setFlash(__('Could not be saved', true));
			}
		}
	}
	
	
	/**
	 * Convenience admin_delete
	 * The goal is to make less code necessary in individual controllers 
	 * and have more reusable code.
	 * @param int $id
	 * @todo Not entirely sure we need to use import for this, and if that isn't a security problem. We need to check and confirm.
	 */
	function __delete($model = null, $id = null) {
		// set default class & message for setFlash
		$class = 'flash_bad';
		$msg   = 'Invalid Id';
		
		// check id is valid
		if(!empty($id)) {
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
			} else {
				$msg = 'Id not found';
			}
		}
	
		// output JSON on AJAX request
		if($this->RequestHandler->isAjax()) {
			$this->autoRender = $this->layout = false;
			echo json_encode(array('success' => ($class=='flash_bad') ? FALSE : TRUE,'msg'=>"<p id='flashMessage' class='{$class}'>{$msg}</p>"));
			exit;
		}
	
		// set flash message & redirect
		$this->Session->setFlash(__($msg, true));
		$this->redirect(Controller::$this->referer());
	}
	
	
	/**
	 * Convenience __ajax_edit 
	 * The goal is to make less code necessary in individual controllers 
	 * and have more reusable code.
	 */
	function __ajax_edit($id = null) {
        if ($this->request->data) {
			# This will not work for multiple fields, and is meant for a form with a single value to update
			# Create the model name from the controller requested in the url
			$model = Inflector::camelize(Inflector::singularize($this->request->params['controller']));
			# These apparently aren't necessary. Left for reference.
			//App::import('Model', $model);
			//$this->$model = new $model();
			# Working to determine if there is a sub model needed, for proper display of updated info
			# For example Project->ProjectStatusType, this is typically denoted by if the field name has _id in it, becuase that means it probably refers to another database table.
			foreach ($this->request->data[$model] as $key => $value) {
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
			
            $this->$model->id = $this->request->data[$model]['id'];
			$fieldValue = $this->request->data[$model][$fieldName];
			
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
	 * Used to show admin layout for admin pages & userRole views if they exist
	 * THIS IS DEPRECATED and will be removed in the future. (after all sites have the latest templates constant.
	 */
	function _siteTemplate() {
		$checkUrl = strpos($this->request->here, '/') === 0 ? substr($this->request->here, 1) : $this->request->here;
		if(defined('__APP_DEFAULT_TEMPLATE_ID') && !empty($this->request->params['prefix']) && $this->request->params['prefix'] == 'admin' && strpos($this->request->params['action'], 'admin_') === 0 && !$this->request->is('ajax')) :
			# this if is for the deprecated constant __APP_DEFAULT_TEMPLATE_ID
			$this->layout = 'default';
			
		
		elseif(!empty($this->request->params['prefix']) && $this->request->params['prefix'] == 'admin' && strpos($this->request->params['action'], 'admin_') === 0 && !$this->request->is('ajax')) :
			if ($this->request->params['prefix'] == CakeSession::read('Auth.User.view_prefix')) :
				# this elseif checks to see if the user role has a specific view file
				$this->request->params['action'] = str_replace('admin_', '', $this->request->params['action']);
				unset($this->request->params['prefix']);
				$this->request->query['url'] = str_replace('admin/', '', $this->request->query['url']);
				$this->request->url = str_replace('admin/', '', $this->request->url);
				$this->request->here = str_replace('/admin', '', $this->request->here);
				$Dispatcher = new Dispatcher();
				$Dispatcher->dispatch($this->request, new CakeResponse(array('charset' => Configure::read('App.encoding'))));
				break;
			else : 
				$this->Session->setFlash(__('Section access restricted.', true));
				$this->redirect($this->referer());
			endif;	
		elseif(!empty($this->request->params['admin']) && $this->request->params['admin'] == 1) :
			foreach (App::path('views') as $path) :
				$paths[] = !empty($this->request->params['plugin']) ? str_replace(DS.'View', DS.'Plugin'.DS.ucfirst($this->request->params['plugin']).DS.'View', $path) : $path;
			endforeach;
			foreach ($paths as $path) :
				if (file_exists($path.CakeSession::read('Auth.User.view_prefix').DS.$this->viewPath.DS.$this->request->params['action'].'.ctp')) :
					$this->viewPath = CakeSession::read('Auth.User.view_prefix').DS.ucfirst($this->request->params['controller']);
				endif;
			endforeach;
			$this->layout = 'default';
		elseif (empty($this->request->params['requested']) && !$this->request->is('ajax') && ($this->request->query['url'] == $checkUrl)) : 
			// this else if makes so that extensions still get parsed
			$this->_getTemplate();
		endif;
	}


	/**
	 * Used to find the template and makes a call to parse all page views.  Sets the defaultTemplate variable for the layout.
	 * This function parses the settings for templates, in order to decide which template to use, based on url, and user role.
	 *
	 * @todo 		Move this to the webpage model.
	 */
	function _getTemplate() {
		if (defined('__APP_TEMPLATES')) :
			$settings = unserialize(__APP_TEMPLATES);
			$i = 0; 
			if (!empty($settings['template'])) : foreach ($settings['template'] as $setting) :
				$templates[$i] = unserialize(gzuncompress(base64_decode($setting)));
				$templates[$i]['userRoles'] = unserialize($templates[$i]['userRoles']);
				$templates[$i]['urls'] = $templates[$i]['urls'] == '""' ? null : unserialize(gzuncompress(base64_decode($templates[$i]['urls'])));
				$i++;
			endforeach; endif;
			
			if (!empty($templates)) : foreach ($templates as $key => $template) : 
				// check urls first so that we don't accidentally use a default template before a template set for this url.
				if (!empty($template['urls'])) : 
					// note : this over rides isDefault, so if its truly a default template, don't set urls
					$this->templateId = $this->_urlTemplate($template);
					// get rid of template values so we don't have to check them twice
					unset($templates[$key]);
				endif;
				if (!empty($this->templateId)) :
					// as soon as we have the first template that matches, end this loop
					break;
				endif;
				
			endforeach; endif;
			if (!empty($templates) && empty($this->templateId)) : foreach ($templates as $key => $template) :
				if (!empty($template['isDefault'])) :
					$this->templateId = $template['templateId'];
					$this->templateId = !empty($template['userRoles']) ? $this->_userTemplate($template) : $this->templateId;
				endif;				
				if (!empty($this->templateId)) :
					// as soon as we have the first template that matches, end this loop
					break;
				endif;				
			endforeach; endif;
				
		elseif (empty($this->templateId)) :
			# THIS ELSE IF IS DEPRECATED 6/11/2011 : Will be removed in future versions
			# it was for use when there were two template related constants, which have now been combined into one.
			if (defined('__APP_DEFAULT_TEMPLATE_ID')) {
           		$this->templateId = __APP_DEFAULT_TEMPLATE_ID;
	            if (defined('__APP_MULTI_TEMPLATE_IDS')) {
					if(is_array(unserialize(__APP_MULTI_TEMPLATE_IDS))) {
						extract(unserialize(__APP_MULTI_TEMPLATE_IDS));
					}
					$i = 0;
					if (!empty($url)) { foreach($url as $u) {
						# check each one against the current url
						$u = str_replace('/', '\/', $u);
						$urlRegEx = '/'.str_replace('*', '(.*)', $u).'/';
						if (preg_match($urlRegEx, $this->request->url)) {
							$this->templateId = $templateId[$i];
						}
						$i++;
					}}
		
					if (!empty($webpages)) { foreach ($webpages as $webpage) {
						echo $webpage['Webpage']['content'];
					}} else {
						# echo 'do nothing, use default template';
					}
	            }
			}
		endif;
		
		$conditions = $this->_templateConditions();
		$templated = $this->Webpage->find('first', $conditions);
		$userRoleId = $this->Session->read('Auth.User.user_role_id');
        $this->Webpage->parseIncludedPages($templated, null, null, $userRoleId);
        $this->set('defaultTemplate', $templated);
		
		# the __APP_DEFAULT_TEMPLATE_ID is deprecated and will be removed
		if (!empty($this->templateId) && !defined('__APP_DEFAULT_TEMPLATE_ID')) :
			$this->layout = 'custom';
		elseif (defined('__APP_DEFAULT_TEMPLATE_ID')) :
			$this->layout = 'custom';
		endif;
	}
	
	
	/**
	 * check if the template selected is available to the current users role
	 * 
	 * @param {array}		Individual template data arrays from the settings.ini (or defaults.ini) file.
	 */
	function _userTemplate($data) {
		// check if the url being requested matches any template settings for user roles
		
		# set a new template id if the session is over writing it
		$currentUserRole = $this->Session->read('viewingRole') ? $this->Session->read('viewingRole') : $this->userRoleId;
			
		if (!empty($data['userRoles'])) : 
			foreach ($data['userRoles'] as $userRole) :
				if ($userRole == $currentUserRole) :
					$templateId = $data['templateId'];
				endif;
			endforeach;
		elseif (!empty($data['templateId'])) :
			$templateId = $data['templateId'];
		endif;
		
		if (!empty($templateId)) : 
			return $templateId;
		else :
			return null;
		endif;
	}
	
	/**
	 * check if the selected template is available to the current url
	 *
	 * @param {array}		Individual template data arrays from the settings.ini (or defaults.ini) file.
	 */
	function _urlTemplate($data) {
		// check if the url being requested matches any template settings for specific urls
		if (!empty($data['urls'])) : 
			$i=0;
			foreach ($data['urls'] as $url) :
				$urlString = str_replace('/', '\/', trim($url));
				$urlRegEx = '/'.str_replace('*', '(.*)', $urlString).'/';
				$urlRegEx = strpos($urlRegEx, '\/') === 1 ? '/'.substr($urlRegEx, 3) : $urlRegEx;
				$url = $this->request->url;
				$urlCompare = strpos($url, '/') === 0 ? substr($url, 1) : $url;
				if (preg_match($urlRegEx, $urlCompare)) :
					$templateId = !empty($data['userRoles']) ? $this->_userTemplate($data) : $data['templateId'];
				endif;
			$i++; 
			endforeach; 
		endif;
		
		if (!empty($templateId)) : 
			return $templateId;
		else :
			return null;
		endif;
	}
	
	
	
	/**
	 * Add conditions based on user role for the template
	 *
	 * @todo		Make slideDock menu available to anyone with permissions to $webpages->edit().  Not just admin
	 */
	function _templateConditions() {
		# contain the menus for output into the slideDock if its the admin user
		if ($this->userRoleId == 1) :		
			$db = ConnectionManager::getDataSource('default');
			$tables = $db->listSources();
			# this is a check to see if this site is upgraded, it can be removed after all sites are upgraded 6/9/2011
			if (array_search('menus', $tables)) { 
				# this allows the admin to edit menus
				$this->Webpage->bindModel(array(
					'hasMany' => array(
						'Menu' => array(
							'className' => 'Menus.Menu', 
							'foreignKey' => '', 
							'conditions' => 'Menu.menu_id is null',
							),
						),
					));
					return array('conditions' => array(
						'Webpage.id' => $this->templateId,
							),
						'contain' => array(
							'Menu' => array(
								'conditions' => array(
									'Menu.menu_id' => null,
									),
								),
							));
			} else {
				return array('conditions' => array('Webpage.id' => $this->templateId));
			}
		else :
			return array('conditions' => array('Webpage.id' => $this->templateId));
		endif;
	}


		
	
/**
 * Loads helpers dynamically system wide, and per controller loading abilities.
 *
 */
	function _getHelpers() {
		if (in_array('Menus', CakePlugin::loaded())) : 
			$this->helpers[] = 'Menus.Tree'; 
		endif;
		
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
 * Checks whether the settings are synced up between defaults and the current settings file. 
 * The idea is, if they aren't in sync then your database is out of date and you need a warning message.
 * 
 * @todo	I think we need to put $uses = 'Setting' into the app model.  (please communicate whether you agree)
 * @todo 	We're now loading these settings files two times on every page load (or more).  This needs to be optimized.
 */
	function _siteStatus() {
		if ($this->userRoleId == 1) {
			$fileSettings = new File(CONFIGS.'settings.ini');
			$fileDefaults = new File(CONFIGS.'defaults.ini');
			# the settings file doesn't exist sometimes, and thats fine
			if ($settings = $fileSettings->read()) {
				App::uses('File', 'Utility');
				 
				$defaults = $fileDefaults->read();
			 
				if ($settings != $defaults) {
				 	$this->set('dbSyncError', '<div class="siteUpgradeNeeded">Site settings are out of date.  Please <a href="/admin">upgrade database</a>. <br> If you think the defaults.ini file is out of date <a href="/admin/settings/update_defaults/">update defaults</a>. <br> If you think the settings.ini file is out of date <a href="/admin/settings/update_settings/">update settings</a></div>');
				 }
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
	
	
	function _getUses() {
		if (in_array('Webpages', CakePlugin::loaded())) : 
			if (is_array($this->uses)) :
				$this->uses = array_merge($this->uses, array('Webpages.Webpage')); 
			else :
				# there is only one (non-array) in $this->uses
				$this->uses = array($this->uses, 'Webpages.Webpage'); 
			endif;
		endif;
	}
   
   
		 
/**
 * Configure AuthComponent
 */
   public function _configAuth() { 
		$authError = defined('__APP_DEFAULT_LOGIN_ERROR_MESSAGE') ? 
			array('message'=> __APP_DEFAULT_LOGIN_ERROR_MESSAGE) : 
			array('message'=> 'Please register or login to access that feature.');
		$this->Auth->authError = $authError['message'];
        $this->Auth->loginAction = array(
			'plugin' => 'users',
			'controller' => 'users',
			'action' => 'login',
			);
		$this->Auth->authorize = array('Controller');
		$this->Auth->authenticate = array(
            'Form' => array(
                'userModel' => 'Users.User',
                'fields' => array('username' => 'username', 'password' => 'password'),
                /*'scope' => array('User.active' => 1)*/
            )
        );
		        
		$this->Auth->actionPath = 'controllers/';
		$this->Auth->allowedActions = array('display');
        $this->Auth->loginRedirect = $this->_defaultLoginRedirect();
		
		if (!empty($this->allowedActions)) {
			$allowedActions = array_merge($this->Auth->allowedActions, $this->allowedActions);
			$this->Auth->allowedActions = $allowedActions;
		}
   }


/**
 * sendMail
 *
 * Send emails.
 * $email: Array - address/name pairs (e.g.: array(example@address.com => name, ...)
 * String - address to send email to
 * $subject: subject of email.
 * $message['html'] in the layout will be replaced with this text. 
 * $template to be picked from folder for email. By default, if $mail is given in any template, especially default, 
 * Else modify the template from the view file and set the variables from action via $this->set
 */
	function __sendMail($email = null, $subject = null, $message = null, $template = 'default', $from = array(), $attachment = null) {
		
		if (defined('__SYSTEM_SMTP')) :
			extract(unserialize(__SYSTEM_SMTP));
			$smtp = base64_decode($smtp);
			$smtp = Security::cipher($smtp, Configure::read('Security.iniSalt'));
			if(parse_ini_string($smtp)) : 
				$this->SwiftMailer->to = $email;
				$this->SwiftMailer->template = $template;
		
				$this->SwiftMailer->layout = 'email';
				$this->SwiftMailer->sendAs = 'html';
		
				if ($message) :
					$this->SwiftMailer->content = $message;
					$message['html'] = $message; 
					$this->set('message', $message);
				endif;
				
				if (!$subject) : 
					$subject = 'No Subject';
				endif;
			
	
				//Set view variables as normal
				return $this->SwiftMailer->send($template, $subject);
			else : 
				return false;
			endif;
		else : 
			return false;
		endif;
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
	 * 
	 * @todo		Move this to the permissions app_controller or somewhere over there.
	 * @todo		Optimize this somehow, someway. 
	 */
	function isAuthorized($user) {
		# this allows all users in the administrators group access to everything
		# using user_role_id is deprecated and will be removed in future versions
		if ($user['view_prefix'] == 'admin' || $user['user_role_id'] == 1) { return true; } 
		# check guest access
		$aro = $this->_guestsAro(); // guest aro model and foreign_key
		$aco = $this->_getAcoPath(); // get aco
		if ($this->Acl->check($aro, $aco)) {
			#echo 'guest access passed';
			#return array('passed' => 1, 'message' => 'guest access passed');
			return true;
		} else {
			# check user access
			$aro = $this->_userAro($user['id']); // user aro model and foreign_key
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
				$this->redirect(array('plugin' => 'users', 'controller' => 'users', 'action' => 'restricted'));
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
		if (!empty($this->request->params['pass'][0])) {
			# check if the record level aco exists first
			$aco = $this->Acl->Aco->find('first', array(
				'conditions' => array(
					'model' => $this->modelClass, 
					'foreign_key' => $this->request->params['pass'][0]
					)
				));
		}
		if(!empty($aco)) {
			return array('model' => $this->modelClass, 'foreign_key' => $this->request->params['pass'][0]);
		} else {
			$controller = Inflector::camelize($this->request->params['controller']);
			$action = $this->request->params['action'];
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
			echo 'In /admin/settings key: SYSTEM, value: GUESTS_USER_ROLE_ID must be defined for guest access to work.';
		}
		return $guestsAro;
	}
	
		
	function authentication(){
		$this->layout = false;
		$this->autoRender = false;

		$data = ($this->request->data);
		$data['requireAuth'] = 0;
		$allowed = array_search($this->request->data['action'], $this->Auth->allowedActions);
		
		if ($allowed === 0 || $allowed > 0 ) {
			$this->Auth->allow('*');
			$data['requireAuth'] = 1;
		}
		echo json_encode($data);			
	}
	
	function runcron()	{
		$this->render(false);
	}
}
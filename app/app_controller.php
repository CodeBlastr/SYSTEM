<?php
class AppController extends Controller {
	
	#var $scaffold;
    var $uses = array('Setting', 'Condition', 'Webpages.Webpage'); 
	var $helpers = array('Session', 'Html', 'Text', 'Form', 'Ajax', 'Javascript', 'Menu', 'Promo', 'Time');
	var $components = array('Acl', 'Auth', 'Session', 'RequestHandler', 'Email', 'RegisterCallbacks');
	var $view = 'Theme';
	var $userGroup = '';

	function beforeFilter() {	
		/*  
		* Allows us to have webroot files (css, js, etc) in the sites directories
		* Used in conjunction with the "var $view above"
		* @todo allow the use of multiple themes, database driven themes, and theme switching
		*/
		$this->theme = 'default';
		
		
        /* 
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
			'plugin' => 'profiles',
			'controller' => 'profiles',
			'action' => 'view',
			'user_id' => $this->Session->read('Auth.User.id')
			);
		
		$this->Auth->actionPath = 'controllers/';
		
		$this->Auth->allowedActions = array('display');
		
		/*
		* Support for json file types when using json extensions
		*/
		$this->RequestHandler->setContent('json', 'text/x-json');
		
		/*
		* app_model doesn't have access to $this->params, we pass it here
		* @todo We'd like to get rid of this completely, if it all possible. 
		* (it seems like a lot of info being pushed to app_model)
		*/
		foreach($this->modelNames as $model) {
			$this->$model->setParams($this->params);
		}
		
		/* 
		* Implemented for allowing guests and creators ACL control
		*/
		$this->userGroup = $this->get_user_group();
		
		/*
		* Used to show admin layout for admin pages
		*/
		if(!empty($this->params['prefix']) && 
		   $this->params['prefix'] == 'admin' && 
		   $this->params['url']['ext'] != 'json' && 
		   $this->params['url']['ext'] != 'rss' && 
		   $this->params['url']['ext'] != 'xml' && 
		   $this->params['url']['ext'] != 'csv') {
			$this->layout = 'admin';
		}
		
		/*
		* System wide settings are set here,
		* by gettting constants for app configuration
		*/
		$this->__getConstants();
		
		/*
		* Used to get database driven template
		*/
		if (defined('__APP_DEFAULT_TEMPLATE_ID')) {
			$defaultTemplate = $this->Webpage->find('first', array('conditions' => array('id' => __APP_DEFAULT_TEMPLATE_ID)));
			$this->__parseIncludedPages ($defaultTemplate);
			$this->set(compact('defaultTemplate'));
		} else {
			echo 'In /admin/settings key: APP, value: DEFAULT_TEMPLATE_ID is not defined';
		}
		
		//if user does not have access check if he / she is the creator and record has creator access.
		
		if($this->Auth->user('id') != 0 && !$this->Auth->isAuthorized()){
			// user is logged in but not authorized.
			// check if node has creator access 
			// 4 is the creator group
			if (defined('__SYS_CREATORS_GROUP_ARO_ID')) {
				if($this->has_access(__SYS_CREATORS_GROUP_ARO_ID , $this->params)){
					//check if record belongs to the user
					if($this->{$this->modelClass}->does_belongs($this->Auth->user('id') , $this->params)){
						//allow user
						$this->Auth->allow('*');
					}
				}
			} else {
				echo 'In /admin/settings key: SYS, value: CREATORS_GROUP_ARO_ID must be defined';
				die;
			}
		}
		
		if (defined('__SYS_GUESTS_GROUP_ARO_ID')) {
			if($this->has_access(__SYS_GUESTS_GROUP_ARO_ID , $this->params)){
				$this->Auth->allow('*');
			}
		} else {
			echo 'In /admin/settings key: SYS, value: GUESTS_GROUP_ARO_ID must be defined';
			die;
		}
    }
    
    /*
     * gets user group for acl check 
     */
    
    function get_user_group(){
    	#get users group
		if($this->Auth->user('id') != 0){
			$user_model = ClassRegistry::init('User');
			$user_moodel->recursive = 1 ;
			$u_data = $user_model->find('first' , array(
				'conditions'=>array('User.id'=>$this->Auth->user('id')),
				'contain'=>array(
					'UserGroup'=>array(
						'fields'=>array(
							'id',
							'name'
						)
					)
				)
				
			));
			
			$perm_aro = ClassRegistry::init('Permissions.Arore');
			$perm_aro->recursive = 0;
			$ar_dat = $perm_aro->find('first' , array(
					'conditions'=>array(
							'Arore.foreign_key'=>$u_data['UserGroup']['id']
					), 
					'contain'=>array(),
					'fields'=>array('id')
			));
			
			return $ar_dat["Arore"]["id"];
			
		}
    }
    
    /*
     * Does the node have creator access ?
     * @param {int} userGroup -> The aro_id of the userGroup 
     * @todo add guest functionality here with a param 
     * @return {bool}
     */
    
    function has_access($userGroup , $params){
     $arac = ClassRegistry::init("Permissions.ArosAco");
     $cn = $arac->find('first' , array(
      'conditions'=>array(
      'ArosAco.aro_id' => $userGroup,
   	/*this was changed to false to get individual records to work (not sure what other effects it will have)
      'ArosAco.aco_id' => $this->{$this->modelClass}->get_aco($params , true)*/
      'ArosAco.aco_id' => $this->{$this->modelClass}->get_aco($params , false)
      ),
      'contain'=>array(),
      /*'fields'=>array(
       '_create',
      )*/
     ));
  
     if(count($cn) != 0){
      if($cn["ArosAco"]["_create"] == 1 ){
       return true;
      }else{
       return false; 
      } 
     }else{
      return false;
     } 

    }

    function beforeRender() {
		if($this->RequestHandler->isAjax()) { 
            Configure::write('debug', 0); 
        } else if ($this->RequestHandler->isXml()) {
            Configure::write('debug', 0); 
		} else if ($this->params['url']['ext'] == 'json') {
            #Configure::write('debug', 0); 
		}
	}
	
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
	
	/* // this might be a bit slower than __getConstants() 
	function __getConfiguration(){
	   //Loading model on the fly
	   #$settings = new Setting();
	   //Fetching All params
	   $settings_array = $this->Setting->findAll();
	   foreach($settings_array as $key=>$value){
	      Configure::write("__".$value['Setting']['key'], $value['Setting']['value']);
	   }
	   $var = Configure::read('__MyApp');
	   #pr($var);
	} */
	
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
	
	function admin_add() {
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
	
	
	function admin_ajax_edit($id = null) {
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
	 * Delete a List
	 * @param int $id
	 */
	function admin_delete($id=null) {
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
	
	
	# show the drop downs for the named parameter 
    function ajax_list($id = null){	
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
	
	
	function __send_mail($id, $subject = null, $message = null, $template = null) {
		# ex call :  $this->__send_mail(array('contact' => array(1, 2), 'user' => array(1, 2)));
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
	##############################################################################################
################# BUILD ACO's ################################################################
################# empty the aco table ########################################################
################# uncomment then go to : http://zuha.localhost/user_groups/build_acl #########
################# then comment out again #####################################################
################# source : http://book.cakephp.org/view/648/Setting-up-permissions ###########
##############################################################################################
	
	
function __build_acl() {
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
		}
	}

	function _getClassMethods($ctrlName = null) {
		App::import('Controller', $ctrlName);
		if (strlen(strstr($ctrlName, '.')) > 0) {
			// plugin's controller
			$num = strpos($ctrlName, '.');
			$ctrlName = substr($ctrlName, $num+1);
		}
		$ctrlclass = $ctrlName . 'Controller';
		$methods = get_class_methods($ctrlclass);

		// Add scaffold defaults if scaffolds are being used
		$properties = get_class_vars($ctrlclass);
		if (array_key_exists('scaffold',$properties)) {
			if($properties['scaffold'] == 'admin') {
				$methods = array_merge($methods, array('admin_add', 'admin_edit', 'admin_index', 'admin_view', 'admin_delete'));
			} else {
				$methods = array_merge($methods, array('add', 'edit', 'index', 'view', 'delete'));
			}
		}
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

		// Get the list of plugins
		$Plugins = $folder->read();
		$Plugins = $Plugins[0];
		$arr = array();

		// Loop through the plugins
		foreach($Plugins as $pluginName) {
			// Change directory to the plugin
			$didCD = $folder->cd(APP . 'plugins'. DS . $pluginName . DS . 'controllers');
			// Get a list of the files that have a file name that ends
			// with controller.php
			$files = $folder->findRecursive('.*_controller\.php');

			// Loop through the controllers we found in the plugins directory
			foreach($files as $fileName) {
				// Get the base file name
				$file = basename($fileName);

				// Get the controller name
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
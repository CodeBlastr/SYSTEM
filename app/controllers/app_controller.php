<?php
class AppController extends Controller {


	var $scaffold;
    var $uses = array('Setting');
	var $helpers = array('Html','Form','Ajax','Javascript','Menu','Time','Tagcloud','FlashChart');
	var $components = array('RequestHandler', 'Acl', 'Email', 'Auth' /*THIS IS MESSING WITH AJAX COMPLETE ### , 'Security'*/);

	function beforeFilter() {
		//Configure AuthComponent
		$this->Auth->authorize = 'actions';
		$this->Auth->loginAction = array('controller' => 'users', 'action' => 'login');
		$this->Auth->logoutRedirect = array('controller' => 'users', 'action' => 'login');
		$this->Auth->loginRedirect = array('controller' => 'settings', 'admin' => 1);
		$this->Auth->actionPath = 'controllers/';
		$this->Auth->allowedActions = array('display');
		//json support
		$this->RequestHandler->setContent('json', 'text/x-json');
    }

    function beforeRender() {
        if($this->RequestHandler->isAjax() || $this->RequestHandler->isXml()) {
            Configure::write('debug', 0);
        }
    }

	function admin_ajax_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id', true));
			$this->redirect(array('action'=>'index'));
		}
		$model = $this->modelClass;
		if ($this->$model->del($id)) {
			$this->redirect('/ajax_delete');
	        $this->layout = 'ajax';
		}
	}

	/*  Does not work on its own, because you'd have to re-run the acl component - by the way, you've got to put that into documentation, as to why new functions don't work.  Its really annoying to not see why something isn't working.
	*/
	function __send_mail($id, $subject = null, $template = null) {
		# ex call :  $this->__send_mail(array('contact' => array(1, 2), 'user' => array(1, 2)));
		if (is_array($id)) :
			if (is_array($id['contact'])):
				foreach ($id['contact'] as $contact_id) :
					$this->__send($contact_id);
				endforeach;
			endif;
			if (is_array($id['user'])):
				foreach ($id['user'] as $user_id) :
					App::import('Model', 'User');
					$this->User = new User();
					$User = $this->User->read(null, $user_id);
					$contact_id = $User['User']['contact_id'];
					$this->__send($contact_id);
				endforeach;
			endif;
		else :
			$this->Session->setFlash(__('Notification ID Invalid', true));
		endif;
    }


	function __send($id) {
		#$this->Email->delivery = 'debug';

		App::import('Model', 'Contact');
		$this->Contact = new Contact();
		$Contact = $this->Contact->read(null,$id);


    	$this->Email->to = $Contact['Contact']['primary_email'];
   		$this->Email->bcc = array('slickricky+secret@gmail.com');
    	$this->Email->subject = 'RazorIT Administrator Notification';
	    $this->Email->replyTo = 'No Reply <noreply@razorit.com>';
	    $this->Email->from = 'No Reply <noreply@razorit.com>';
	    $this->Email->template = 'project_issue_new';
	    $this->Email->sendAs = 'both';
	    $this->set('Contact', $Contact);
	    $this->Email->send();
		#pr($this->Session->read('Message.email'));
		#die;
		#$this->Email->reset();
	}

##############################################################################################
################# BUILD ACO's ################################################################
################# empty the aco table ########################################################
################# uncomment then go to : http://zuha.localhost/user_groups/build_acl #########
################# then comment out again #####################################################
################# source : http://book.cakephp.org/view/648/Setting-up-permissions ###########
##############################################################################################


/** function build_acl() {
		if (!Configure::read('debug')) {
			return $this->_stop();
		}
		$log = array();

		$aco =& $this->Acl->Aco;
		$root = $aco->node('controllers');
		if (!$root) {
			$aco->create(array('parent_id' => null, 'model' => null, 'alias' => 'controllers'));
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
			$methods = $this->_getClassMethods($this->_getPluginControllerPath($ctrlName));

			// Do all Plugins First
			if ($this->_isPlugin($ctrlName)){
				$pluginNode = $aco->node('controllers/'.$this->_getPluginName($ctrlName));
				if (!$pluginNode) {
					$aco->create(array('parent_id' => $root['Aco']['id'], 'model' => null, 'alias' => $this->_getPluginName($ctrlName)));
					$pluginNode = $aco->save();
					$pluginNode['Aco']['id'] = $aco->id;
					$log[] = 'Created Aco node for ' . $this->_getPluginName($ctrlName) . ' Plugin';
				}
			}
			// find / make controller node
			$controllerNode = $aco->node('controllers/'.$ctrlName);
			if (!$controllerNode) {
				if ($this->_isPlugin($ctrlName)){
					$pluginNode = $aco->node('controllers/' . $this->_getPluginName($ctrlName));
					$aco->create(array('parent_id' => $pluginNode['0']['Aco']['id'], 'model' => null, 'alias' => $this->_getPluginControllerName($ctrlName)));
					$controllerNode = $aco->save();
					$controllerNode['Aco']['id'] = $aco->id;
					$log[] = 'Created Aco node for ' . $this->_getPluginControllerName($ctrlName) . ' ' . $this->_getPluginName($ctrlName) . ' Plugin Controller';
				} else {
					$aco->create(array('parent_id' => $root['Aco']['id'], 'model' => null, 'alias' => $ctrlName));
					$controllerNode = $aco->save();
					$controllerNode['Aco']['id'] = $aco->id;
					$log[] = 'Created Aco node for ' . $ctrlName;
				}
			} else {
				$controllerNode = $controllerNode[0];
			}

			//clean the methods. to remove those in Controller and private actions.
			foreach ($methods as $k => $method) {
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
					$aco->create(array('parent_id' => $controllerNode['Aco']['id'], 'model' => null, 'alias' => $method));
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


 # Get the names of the plugin controllers ...
 # This function will get an array of the plugin controller names, and
 # also makes sure the controllers are available for us to get the
 # method names by doing an App::import for each plugin controller.
 #  @return array of plugin names.

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
**/


}
?>
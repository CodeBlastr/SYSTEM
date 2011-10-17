<?php

class AppExceptionHandler {
	
	public static function handle($error) {
		debug($error->getCode());
		echo 'Oh noes! ' . $error->getMessage();
        $this->sendEmail();
    }
	
	/*
    public static function handleError($code, $description, $file = null, $line = null, $context = null) {
        echo 'There has been an error!';
		error_reporting(E_ALL);
		ini_set("display_errors", 1);
		debug($code);
		debug($description);
		debug($file);
		debug($line);
		debug($context);
		
		
		$Alias = ClassRegistry::init('Alias');
		if (empty($params['url'])) {
			$params['url'] = 'home';
		} else {
			# seems it was getting over sanitized because dashes were being replaced.  Just converting them back.
			$params['url'] = str_replace('&#45;', '-', $params['url']);
		}
		if (substr($params['url'], -1) == '/') {
			$params['url'] = str_replace('/', '', $params['url']);
		}
		$alias = $Alias->find("first", array("conditions" => array( "name" => $params['url'])));
		if(!empty($alias)) {
			$url = '/';
			(!empty($alias['Alias']['plugin']) ? $url = $url.$alias['Alias']['plugin'].'/' : '');
			(!empty($alias['Alias']['controller']) ? $url = $url.$alias['Alias']['controller'].'/' : '');
			(!empty($alias['Alias']['action']) ? $url = $url.$alias['Alias']['action'].'/' : '');
			(!empty($alias['Alias']['value']) ? $url = $url.$alias['Alias']['value'].'/' : '');
			$Dispatcher = new Dispatcher();
	     	$Dispatcher->dispatch($url);
		} else {
			$this->addPageRedirect($params);
			
			extract($params, EXTR_OVERWRITE);
			$this->error(array(
				'code' => '404',
				'name' => 'Not found',
				'message' => sprintf(__("%s %s", true), $url, $message)));
			$this->_stop();
		}
        exit;
    }
	

    function missingController($params) {
		$this->error404($params, '(Error code: 9340237983)');
    }


	/** 
	 * Checks to see whether the user is logged in as an admin, and then redirects to the add page form 
	 * to see if they would like to create a page for that url.
	 *
	 * @return		a redirect action, or false
	 
	function addPageRedirect($params) {
		# lets see if the user would like to add a page if they are an admin
		App::import('Component', 'Session');
		$this->Session = new SessionComponent();
		$userRole = $this->Session->read('Auth.User.user_role_id');
		if($userRole == 1 /* Admin user role ) {
			App::import('Controller', 'AppController');
			$this->AppController = new AppController();
			$this->Session->setFlash(__('No page exists at '.$params['url'].', would you like to create it?', true) );
			$this->AppController->redirect(array('plugin' => 'webpages', 'controller' => 'webpages', 'action'=>'add', 'alias' => $params['url'], 'admin' => 0));
		} else {
			return false;
		}
	} */
}
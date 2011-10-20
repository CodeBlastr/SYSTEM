<?php
App::uses('ExceptionRenderer', 'Error');

class AppExceptionRenderer extends ExceptionRenderer {
	
	#public function missingController($error) {
	#	$this->handleError($error);
    #}
	
	protected function _getController($exception) {
		App::uses('AppErrorController', 'Controller');
		if (!$request = Router::getRequest(false)) {
			$request = new CakeRequest();
		}
		$response = new CakeResponse(array('charset' => Configure::read('App.encoding')));
		try {
			$controller = new AppErrorController($request, $response);
		} catch (Exception $e) {
			$controller = new Controller($request, $response);
			$controller->viewPath = 'Errors';
		}
		return $controller;
	}
	
}




	/*
		debug($error->getCode());
        if ($error instanceof MissingControllerException) {
			echo 'alskdjflaksjdf';
			debug($this->var);
			debug('missing controller alskdfjalskdfj laskdfj ');
		} */

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
	} 
}*/
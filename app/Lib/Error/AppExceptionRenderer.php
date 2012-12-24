<?php
App::uses('ExceptionRenderer', 'Error');

class AppExceptionRenderer extends ExceptionRenderer {
		
	protected function _getController($exception) {
		App::uses('AppErrorController', 'Controller');
		if (!$request = Router::getRequest(false)) {
			$request = new CakeRequest();
		}
		$response = new CakeResponse(array('charset' => Configure::read('App.encoding')));
		$Controller = new AppErrorController($request, $response);
		
		try {
			$Controller::handleAlias($request, $exception); // checks for alias match
		} catch (Exception $e) {
			try {
				$Controller::handleNotFound($request, $response, $e, $exception);
			} catch (Exception $e) {
				$Controller = new Controller($request, $response);
				$Controller->viewPath = 'Errors';
			}
		}
		return $Controller;
	} 
	
}
<?php
App::uses('ExceptionRenderer', 'Error');

class AppExceptionRenderer extends ExceptionRenderer {
	
	protected function _getController($exception) {
		if (Configure::read('debug') > 0) {
			if (get_class($exception) == 'MissingTableException') {
				// had to put this in because debugger would fix the error and you'd never see it
				debug($exception->getMessage());
			} elseif (get_class($exception) == 'PDOException') {
				// had to put this in because debugger would fix the error and you'd never see it
				debug($exception->getMessage());
			}
		}
		App::uses('AppErrorController', 'Controller');
		if (!$request = Router::getRequest(false)) {
			$request = new CakeRequest();
		}
		$response = new CakeResponse(array('charset' => Configure::read('App.encoding')));
		
		$Controller = new AppErrorController($request, $response);
		//Needed to add this check to allow errors from testing to be displayed WHY DIDN'T WE COMMENT THE REMOVAL OF IT THEN!!!
		//if(!defined('APP_TEST_CASES')) {
			if (get_class($exception) == 'MissingPluginException') {
				try {
					$Controller->handleMissingPlugin($request, $exception);
				} catch (Exception $e) {
					debug($e->getMessage());
					break;
				}
			} else {
				try {
					$Controller->handleAlias($request, $exception); // checks for alias match
				} catch (Exception $e) {
					try {
						$Controller->handleNotFound($request, $response, $e, $exception);
					} catch (Exception $e) {
						$Controller = new Controller($request, $response);
						$Controller->viewPath = 'Errors';
					}
				}
			}
		//}
		return $Controller;
	} 
	
}
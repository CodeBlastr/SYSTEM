<?php
/**
 * Handles Some Error Page Methods
 *
 * Used primarily to check if an error should atually be redirected to an alias
 * set in the alias database table
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
class AppError extends ErrorHandler{
	
	/** 
	 * Handles the alias redirects if the alias exists.
	 */
    function error404($params, $message) {
		App::import('Model', 'Alias');
		$this->Alias = new Alias();	
		if (empty($params['url'])) {
			$params['url'] = 'home';
		} else {
			# seems it was getting over sanitized because dashes were being replaced.  Just converting them back.
			$params['url'] = str_replace('&#45;', '-', $params['url']);
		}
		if (substr($params['url'], -1) == '/') {
			$params['url'] = str_replace('/', '', $params['url']);
		}
		$alias = $this->Alias->find("first", array("conditions" => array( "name" => $params['url'])));
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
	 */
	function addPageRedirect($params) {
		# lets see if the user would like to add a page if they are an admin
		App::import('Component', 'Session');
		$this->Session = new SessionComponent();
		$userRole = $this->Session->read('Auth.User.user_role_id');
		if($userRole == 1 /* Admin user role */) {
			App::import('Controller', 'AppController');
			$this->AppController = new AppController();
			$this->Session->setFlash(__('No page exists at '.$params['url'].', would you like to create it?', true) );
			$this->AppController->redirect(array('plugin' => 'webpages', 'controller' => 'webpages', 'action'=>'add', 'alias' => $params['url']));
		} else {
			return false;
		}
	}
	
}
?>

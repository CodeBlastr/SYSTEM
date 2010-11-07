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
    function error404($params) {
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
			extract($params, EXTR_OVERWRITE);
			$this->error(array('code' => '404',
							'name' => 'Not found',
							'message' => sprintf(__("The requested address %s was not found on this server.", true), $url, $message)));
			$this->_stop();
		}
        exit;
    }

    function missingController($params) {
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
			extract($params, EXTR_OVERWRITE);
			$this->error(array('code' => '404',
							'name' => 'Not found',
							'message' => sprintf(__('Missing controller: '.$params['url'], true), $url)));
			$this->_stop();
		}
        exit;
    }
	
	function missingView($params) {
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
			extract($params, EXTR_OVERWRITE);
			$this->error(array('code' => '404',
							'name' => 'Not found',
							'message' => sprintf(__('Missing view: '.$params['url'], true), $url)));
			$this->_stop();
		}
        exit;
	}
	
	
}
?>

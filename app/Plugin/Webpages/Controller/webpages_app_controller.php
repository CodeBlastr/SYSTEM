<?php	
/**
 * Webpages App Controller
 *
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
 * @link          http://zuha.com Zuha™ Project
 * @package       zuha
 * @subpackage    zuha.app.plugins.webpages
 * @since         Zuha(tm) v 0.0.1
 * @license       GPL v3 License (http://www.gnu.org/licenses/gpl.html) and Future Versions
 */
 
App::import(array(
	'type' => 'File', 
	'name' => 'Webpages.WebpagesConfig', 
	'file' =>  '..' . DS . 'plugins'  . DS  . 'webpages'  . DS  . 'config'. DS .'core.php'
));
class WebpagesAppController extends AppController {		
		
	function beforeFilter(){
		parent::beforeFilter();
	
		$Config = WebpagesConfig::getInstance();
		# sets display values
		if (!empty($Config->settings[$this->params['controller'].Inflector::camelize($this->params['action']).'View'])) {
			$this->set('settings', $Config->settings[$this->params['controller'].Inflector::camelize($this->params['action']).'View']);
		}
		# sets the controller values
		if (!empty($Config->settings[$this->params['controller'].Inflector::camelize($this->params['action']).'Controller'])) {
			$this->settings = $Config->settings[$this->params['controller'].Inflector::camelize($this->params['action']).'Controller'];
		}
	}
}

?>
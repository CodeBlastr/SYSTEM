<?php
ini_set('session.cookie_httponly', true); // used for PCI compliance to make session unavailable to Javascript, can be overwritten on a site by site level

if (defined('SITE_DIR') && file_exists(ROOT.DS.SITE_DIR.DS.'Config'.DS.'core.php')) {
	// we are in a site within the sites directory
  	require_once(ROOT.DS.SITE_DIR.DS.'Config'.DS.'core.php');
    Configure::write('Session.cookie', 'PHPSESSID');
} else {
	// we are installing a new site here
	require_once(ROOT . DS . 'sites' . DS . 'example.com' . DS . 'Config' . DS . 'core.php');
  	$debugger = !empty($_GET['debugger']) ? $_GET['debugger'] : 2;
  	Configure::write('debug', $debugger);
  	Configure::write('Config.language', 'en');  
}
    
Configure::write('Error', array(
  'handler' => 'ErrorHandler::handleError',
  'level' => E_ALL & ~E_DEPRECATED,
  'trace' => true
  ));
Configure::write('Exception', array(
  'handler' => 'ErrorHandler::handleException',
  'renderer' => 'AppExceptionRenderer',
  'log' => true
));

App::uses('AppErrorHandler', 'Lib/Error');

Configure::write('Exception', array(
  'handler' => 'AppErrorHandler::handleException',
  'renderer' => 'AppExceptionRenderer',
  'log' => true
  ));

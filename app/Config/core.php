<?php
ini_set('session.cookie_httponly', true); // used for PCI compliance to make session unavailable to Javascript, can be overwritten on a site by site level

if (defined('SITE_DIR')) {
	// we are in a site within the sites directory
  	if (@include(ROOT.DS.SITE_DIR.DS.'Config'.DS.'core.php')) {
    	Configure::write('Session.cookie', 'PHPSESSID');
  	} else {
  		echo 'Core.php File is Missing';
		break;
  	}
} else {
	// we are installing a new site here
	// OR using the cake console
	if (php_sapi_name() !== 'cli') {
	    if ($_SERVER['SCRIPT_URL'] != '/install/site') {
	        header('Location: /install/site');
	        break;
		}
		Configure::write('Install', true);
	}
	require_once(ROOT . DS . 'sites' . DS . 'example.com' . DS . 'Config' . DS . 'core.php');
  	$debugger = !empty($_GET['debugger']) ? $_GET['debugger'] : 2;
  	Configure::write('debug', $debugger);
  	Configure::write('Config.language', 'en');
}
    
Configure::write('Error', array(
  'handler' => 'ErrorHandler::handleError',
  'level' => E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED,
  'trace' => true
  ));
// this is the same config variable as the one below??? 6/14/2013 rk
//Configure::write('Exception', array(
//  'handler' => 'ErrorHandler::handleException',
//  'renderer' => 'AppExceptionRenderer',
//  'log' => true
//));
App::uses('AppErrorHandler', 'Lib/Error');
Configure::write('Exception', array(
  'handler' => 'AppErrorHandler::handleException',
  'renderer' => 'AppExceptionRenderer',
  'log' => true
  ));

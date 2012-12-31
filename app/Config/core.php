<?php
ini_set('session.cookie_httponly', true); // used for PCI compliance to make session unavailable to Javascript, can be overwritten on a site by site level

if (defined('SITE_DIR') && file_exists(ROOT.DS.SITE_DIR.DS.'Config'.DS.'core.php')) {
	require_once(ROOT.DS.SITE_DIR.DS.'Config'.DS.'core.php');
	Configure::write('Session.cookie', 'PHPSESSID');
} else {
	// this else fires on install/site so we can't have die() here.
	//echo 'no core.php file exists';
	//die();
	$debugger = !empty($_GET['debugger']) ? $_GET['debugger'] : 2;
	// Configure::write('debug', 2);
	Configure::write('debug', $debugger);
	Configure::write('Config.language', 'en');

/**
 * A random string used in security hashing methods.
 */
	Configure::write('Security.salt', 'DYhuf92384jr348ru92834fokjahk4j98C9mi');

/**
 * A random numeric string (digits only) used to encrypt/decrypt strings.
 */
	Configure::write('Security.cipherSeed', '76859309657453474798792837498');
	
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
	
}

App::uses('AppErrorHandler', 'Lib/Error');

Configure::write('Exception', array(
	'handler' => 'AppErrorHandler::handleException',
	'renderer' => 'AppExceptionRenderer',
	'log' => true
	));

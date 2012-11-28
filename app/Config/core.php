<?php
// SECRET PART

Configure::write('Recaptcha.privateKey', '6Lc5xsMSAAAAADJmj-bruuzCYXOeSg5Mf7JTyW3e');
Configure::write('Recaptcha.publicKey', '6Lc5xsMSAAAAAAoP0DkzEcoBHvHeQ2mO506mHnRY'); // don't know if this is needed

// SECRET END
ini_set('session.cookie_httponly', true); // used for PCI compliance to make session unavailable to Javascript, can be overwritten on a site by site level

if (defined('SITE_DIR') && file_exists(ROOT.DS.SITE_DIR.DS.'Config'.DS.'core.php')) {
	
	require_once(ROOT.DS.SITE_DIR.DS.'Config'.DS.'core.php');
	Configure::write('Session.cookie', 'PHPSESSID');

}

// SECRET PART 

else if (
	!defined('SITE_DIR') && 
	strpos($_SERVER['HTTP_HOST'], '.zuha.com') &&
	basename($_SERVER['REQUEST_URI']) == 'site') {
		define('IS_ZUHA', true);
		define('SITE_DIR', 'sites'.DS.'zuha.com');
		require_once(ROOT.DS.'sites'.DS.'zuha.com'.DS.'Config'.DS.'core.php');
} else if (
	!defined('SITE_DIR') && 
	strpos($_SERVER['HTTP_HOST'], '.zuha.com')) {
		//header('Location: /install/site');
} 

// END SECRET PART  

else {
	
	$debugger = !empty($_GET['debugger']) ? $_GET['debugger'] : 2;
	// Configure::write('debug', 2);
	Configure::write('debug', $debugger);
	Configure::write('Config.language', 'en');
	
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

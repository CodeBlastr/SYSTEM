<?php
if (defined('SITE_DIR') && file_exists(ROOT.DS.SITE_DIR.DS.'Config'.DS.'core.php')) {
	require_once(ROOT.DS.SITE_DIR.DS.'Config'.DS.'core.php');
	Configure::write('Session.cookie', 'PHPSESSID');
} 

// THESE ARE ONLY FOR THIS ZUHA SERVER : DO NOT MAKE PUBLIC
// IT IS WHAT MAKES ZUHA A SAAS 

/*else if (
	!defined('SITE_DIR') && 
	strpos($_SERVER['HTTP_HOST'], '.zuha.com') &&
	basename($_SERVER['REQUEST_URI']) == 'site') {
		define('IS_ZUHA', true);
		define('SITE_DIR', 'sites'.DS.'zuha.com');
		require_once(ROOT.DS.'sites'.DS.'zuha.com'.DS.'Config'.DS.'core.php');
}else if (
	!defined('SITE_DIR') && 
	strpos($_SERVER['HTTP_HOST'], '.zuha.com')) {
		//header('Location: /install/site');
} */ else {
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

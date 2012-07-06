<?php
if (defined('SITE_DIR') && file_exists(ROOT.DS.SITE_DIR.DS.'Config'.DS.'core.php')) {
	require_once(ROOT.DS.SITE_DIR.DS.'Config'.DS.'core.php');
	Configure::write('Session.cookie', 'PHPSESSID');
} else {
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
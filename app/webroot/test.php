<?php
#phpinfo();
/**
 * Web Access Frontend for TestSuite
 *
 * PHP 5
 *
 * CakePHP(tm) Tests <http://book.cakephp.org/view/1196/Testing>
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://book.cakephp.org/view/1196/Testing
 * @package       app.webroot
 * @since         CakePHP(tm) v 1.2.0.4433
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
set_time_limit(0);
ini_set('display_errors', 1);
/**
 * Use the DS to separate the directories in other defines
 */
	if (!defined('DS')) {
		define('DS', DIRECTORY_SEPARATOR);
	}
/**
 * These defines should only be edited if you have cake installed in
 * a directory layout other than the way it is distributed.
 * When using custom settings be sure to use the DS and do not add a trailing DS.
 */

/**
 * The full path to the directory which holds "app", WITHOUT a trailing DS.
 *
 */
	if (!defined('ROOT')) {
		define('ROOT', dirname(dirname(dirname(__FILE__))));
	}
    
/**
* For multi site setups 
* Define which the urls point to which sites directories in the file /sites/bootstrap.php
*/
	if (file_exists(ROOT . DS . 'sites' . DS . 'bootstrap.php')) {
		require_once(ROOT . DS . 'sites' . DS . 'bootstrap.php');
	} 

/** 
 * Redirect to install if zuha isn't installed yet.
 */
	if (!defined('SITE_DIR') && basename($_SERVER['REQUEST_URI']) != 'install' && basename($_SERVER['REQUEST_URI']) != 'site') {
		header('Location: /install/site/');
	} 
/**
 * The actual directory name for the "app".
 *
 */
	if (!defined('APP_DIR')) {
		define('APP_DIR', basename(dirname(dirname(__FILE__))));
	}
	
/**
 * Zuha updated tmp directory to support sites directory
 */
	if (!defined('TMP')) {
		if (defined('SITE_DIR')) {
 			define('TMP', ROOT . DS . SITE_DIR . DS . 'tmp' . DS);
		} else {
 			define('TMP', ROOT . DS . APP_DIR . DS . 'tmp' . DS);
		}
	}
	
/**
 * Zuha added constant because CakePHP 2.0 removed it
 *
 */
	if (!defined('CONFIGS')) :
		if (defined('SITE_DIR')) : 
			define('CONFIGS', ROOT .DS . SITE_DIR . DS . 'Config' . DS);
		else : 
			define('CONFIGS', ROOT .DS . APP_DIR . DS . 'Config' . DS);
		endif;
	endif;

/**
 * The absolute path to the "Cake" directory, WITHOUT a trailing DS.
 *
 * For ease of development CakePHP uses PHP's include_path.  If you
 * need to cannot modify your include_path, you can set this path.
 *
 * Leaving this constant undefined will result in it being defined in Cake/bootstrap.php
 */
	//define('CAKE_CORE_INCLUDE_PATH', ROOT . DS . 'lib');

/**
 * Editing below this line should not be necessary.
 * Change at your own risk.
 *
 */
if (!defined('WEBROOT_DIR')) {
	define('WEBROOT_DIR', basename(dirname(__FILE__)));
}
if (!defined('WWW_ROOT')) {
	define('WWW_ROOT', dirname(__FILE__) . DS);
}

if (!defined('CAKE_CORE_INCLUDE_PATH')) {
	if (function_exists('ini_set')) {
		ini_set('include_path', ROOT . DS . 'lib' . PATH_SEPARATOR . ini_get('include_path'));
	}
	if (!include('Cake' . DS . 'bootstrap.php')) {
		$failed = true;
	}
} else {
	if (!include(CAKE_CORE_INCLUDE_PATH . DS . 'Cake' . DS . 'bootstrap.php')) {
		$failed = true;
	}
}
if (!empty($failed)) {
	trigger_error("CakePHP core could not be found.  Check the value of CAKE_CORE_INCLUDE_PATH in APP/webroot/index.php.  It should point to the directory containing your " . DS . "cake core directory and your " . DS . "vendors root directory.", E_USER_ERROR);
}

if (Configure::read('debug') < 1) {
	die(__d('cake_dev', 'Debug setting does not allow access to this url.'));
}

require_once CAKE . 'TestSuite' . DS . 'CakeTestSuiteDispatcher.php';

CakeTestSuiteDispatcher::run();

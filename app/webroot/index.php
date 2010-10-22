<?php
/**
 * Index
 *
 * The Front Controller for handling every request
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.app.webroot
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
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
* If you want to define a site folder
* instead of using the default server http host to find the site folder
* do it here
*/
	if ($_SERVER['HTTP_HOST'] == 'adoptamodel.localhost' || $_SERVER['HTTP_HOST'] == 'adoptamodel.zuha.com') {
		if (!defined('SITE_DIR')) {
			# this is the site combined local and remote sites directory
			define('SITE_DIR', 'adoptamodel.zuha.com');
		}
	} else if ($_SERVER['HTTP_HOST'] == 'crimetv.zuha.localhost' || $_SERVER['HTTP_HOST'] == 'crimetv.zuha.com' || $_SERVER['HTTP_HOST'] == 'crimetv.localhost') {
		if (!defined('SITE_DIR')) {
			# this is the site combined local and remote sites directory
			define('SITE_DIR', 'crimetv.zuha.com');
		}
	} else if ($_SERVER['HTTP_HOST'] == 'getrooted.localhost' || $_SERVER['HTTP_HOST'] == 'getrooted.zuha.localhost' || $_SERVER['HTTP_HOST'] == 'getrooted.zuha.com' || $_SERVER['HTTP_HOST'] == 'getrooted.org') {
		if (!defined('SITE_DIR')) {
			define('SITE_DIR', 'getrooted.com');
		}
	} else if ($_SERVER['HTTP_HOST'] == 'joinmyrfq.localhost' || $_SERVER['HTTP_HOST'] == 'joinmyrfq.zuha.com') {
		if (!defined('SITE_DIR')) {
			# this is the site combined local and remote sites directory
			define('SITE_DIR', 'joinmyrfq.com');
		}
	} else if ($_SERVER['HTTP_HOST'] == 'planetcolor.localhost' || $_SERVER['HTTP_HOST'] == 'planetcolor.biz') {
		if (!defined('SITE_DIR')) {
			# this is the site combined local and remote sites directory
			define('SITE_DIR', 'planetcolor.biz');
		}
	} else if ($_SERVER['HTTP_HOST'] == 'wwbe.localhost' || $_SERVER['HTTP_HOST'] == 'wwbe.92rm.com') {
		if (!defined('SITE_DIR')) {
			# this is the site combined local and remote sites directory
			define('SITE_DIR', 'wwbe.com');
		}
	} else if ($_SERVER['HTTP_HOST'] == 'razorit.localhost' || $_SERVER['HTTP_HOST'] == 'www2.razorit.com') {
		if (!defined('SITE_DIR')) {
			# this is the site combined local and remote sites directory
			define('SITE_DIR', 'www2.razorit.com');
		}
	} else if ($_SERVER['HTTP_HOST'] == 'zuha.localhost' || $_SERVER['HTTP_HOST'] == 'zuha.com') {
		if (!defined('SITE_DIR')) {
			# this is the site combined local and remote sites directory
			define('SITE_DIR', 'zuha.com');
		}
	} else {
		if (!defined('SITE_DIR')) {
			define('SITE_DIR', $_SERVER['HTTP_HOST']);
		} 
	}
	
	//print($_SERVER['HTTP_HOST']);
	
/**
 * The actual directory name for the "app".
 *
 */
	
	if (!defined('APP_DIR')) {
		if (file_exists(ROOT.DS.'sites'.DS.SITE_DIR)) {
			define('APP_DIR', 'sites'.DS.SITE_DIR);
		} else {
			define('APP_DIR', basename(dirname(dirname(__FILE__))));
		}
	}
/**
 * The absolute path to the "cake" directory, WITHOUT a trailing DS.
 *
 */
	if (!defined('CAKE_CORE_INCLUDE_PATH')) {
		define('CAKE_CORE_INCLUDE_PATH', ROOT);
	}

/**
 * Editing below this line should NOT be necessary.
 * Change at your own risk.
 *
 */
	if (!defined('WEBROOT_DIR')) {
		define('WEBROOT_DIR', basename(dirname(__FILE__)));
	}
	if (!defined('WWW_ROOT')) {
		define('WWW_ROOT', dirname(__FILE__) . DS);
	}
	if (!defined('CORE_PATH')) {
		if (function_exists('ini_set') && ini_set('include_path', CAKE_CORE_INCLUDE_PATH . PATH_SEPARATOR . ROOT . DS . APP_DIR . DS . PATH_SEPARATOR . ini_get('include_path'))) {
			define('APP_PATH', null);
			define('CORE_PATH', null);
		} else {
			define('APP_PATH', ROOT . DS . APP_DIR . DS);
			define('CORE_PATH', CAKE_CORE_INCLUDE_PATH . DS);
		}
	}
	if (!include(CORE_PATH . 'cake' . DS . 'bootstrap.php')) {
		trigger_error("CakePHP core could not be found.  Check the value of CAKE_CORE_INCLUDE_PATH in APP/webroot/index.php.  It should point to the directory containing your " . DS . "cake core directory and your " . DS . "vendors root directory.", E_USER_ERROR);
	}
	if (isset($_GET['url']) && $_GET['url'] === 'favicon.ico') {
		return;
	} else {
		$Dispatcher = new Dispatcher();
		$Dispatcher->dispatch();
	}

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
	$prefix = SITE_DIR;
} else {
	// we are installing a new site here
	// OR using the cake console
	if (php_sapi_name() !== 'cli') {
	    if ($_SERVER['REQUEST_URI'] != '/install/site') {
	        //header('Location: /install/site'); // switch with line below to allow installs at a catchall
	        header('Location: http://buildrr.com/');
	        break;
		}
		//Configure::write('Install', true); // switch with line below to allow installs at a catchall
		Configure::write('Install', false);
	}
	require_once(ROOT . DS . 'sites' . DS . 'example.com' . DS . 'Config' . DS . 'core.php');
  	$debugger = !empty($_GET['debugger']) ? $_GET['debugger'] : 2;
  	Configure::write('debug', $debugger);
  	Configure::write('Config.language', 'en');
	$prefix = 'console';
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
  
Cache::config('default', array(
 	'engine' => 'Apc', //[required]
 	'duration'=> 3600, //[optional]
 	'probability'=> 100, //[optional]
 	'prefix' => Inflector::slug($prefix) . '_', //[optional]  prefix every cache file with this string
 	));

/**
 * Pick the caching engine to use.  If APC is enabled use it.
 * If running via cli - apc is disabled by default. ensure it's available and enabled in this case
 *
 */
$engine = 'Memcache';
if (extension_loaded('apc') && (php_sapi_name() !== 'cli' || ini_get('apc.enable_cli'))) {
	$engine = 'Apc';
}

// In development mode, caches should expire quickly.
$duration = '+999 days';
if (Configure::read('debug') >= 1) {
	$duration = '+10 seconds';
}

/**
 * Configure the cache used for general framework caching.  Path information,
 * object listings, and translation cache files are stored with this configuration.
 */
Cache::config('_cake_core_', array(
	'engine' => $engine,
	'prefix' => 'cake_core_' . Inflector::slug($prefix) . '_',
	'path' => CACHE . 'persistent' . DS,
	'serialize' => ($engine === 'File'),
	'duration' => $duration
));

/**
 * Configure the cache for model and datasource caches.  This cache configuration
 * is used to store schema descriptions, and table listings in connections.
 */
Cache::config('_cake_model_', array(
	'engine' => $engine,
	'prefix' => 'cake_model_' . Inflector::slug($prefix) . '_',
	'path' => CACHE . 'models' . DS,
	'serialize' => ($engine === 'File'),
	'duration' => $duration
));

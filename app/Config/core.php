<?php
/**
 * PCI Compliance to make session unavailable to Javascript
 */
	ini_set('session.cookie_httponly', true);


/**
 * Application wide charset encoding.
 */
	Configure::write('App.encoding', 'UTF-8');

/**
 * Routing prefixes configuration.  Default is admin
 *
 */
	Configure::write('Routing.prefixes', array('admin'));
	
/**
 * Turn off all caching application-wide.
 *
 */
	//Configure::write('Cache.disable', true);

/**
 * Enable cache checking.
 *
 * If set to true, for view caching you must still use the controller
 * public $cacheAction inside your controllers to define caching settings.
 * You can either set it controller-wide by setting public $cacheAction = true,
 * or in each action using $this->cacheAction = true.
 *
 */
	//Configure::write('Cache.check', true);
	
/**
 * Defines the default error type when using the log() function. Used for
 * differentiating error logging and debugging. Currently PHP supports LOG_DEBUG.
 */
	define('LOG_ERROR', 2);
	
/**
 * A secret file for backdoor access
 */
	if (file_exists(ROOT . DS . 'app' . DS . 'Config' . DS . '.secret.php')) {
		require_once(ROOT . DS . 'app' . DS . 'Config' . DS . '.secret.php');
	}

/**
 * Multi site and install constants and handling
 */
	if (defined('SITE_DIR')) {
		// we are in a site within the sites directory
	  	if (@include(ROOT.DS.SITE_DIR.DS.'Config'.DS.'core.php')) {
	    	Configure::write('Session.cookie', 'PHPSESSID');
	  	} else {
	  		echo 'Core.php File is Missing';
			exit;
	  	}
		$prefix = SITE_DIR;
	} else {
		// we are installing a new site here
		// OR using the cake console
		if (php_sapi_name() !== 'cli') {
		    if ($_SERVER['REQUEST_URI'] != '/install/site') {
		        header('Location: /install/site'); // switch with line below to allow installs at a catchall
		        //header('Location: http://buildrr.com/');
		        exit;
			}
			Configure::write('Install', true); // switch with line below to allow installs at a catchall
			//Configure::write('Install', false);
		}
		if (file_exists(ROOT . DS . 'sites' . DS . 'example.com' . DS . 'Config' . DS . 'core.php')) {
			require_once(ROOT . DS . 'sites' . DS . 'example.com' . DS . 'Config' . DS . 'core.php');
		} else {
			require_once(ROOT . DS . 'sites.default' . DS . 'example.com' . DS . 'Config' . DS . 'core.php');
		}
	  	$debugger = !empty($_GET['debugger']) ? $_GET['debugger'] : 2;
	  	Configure::write('debug', $debugger);
	  	Configure::write('Config.language', 'en');
		$prefix = 'console';
	}

/**
 * Forced error handler
 * 
 * IMPORTANT : This is deprecated and will be removed  on July 15, 2014 (put here on June 15, 2014) - RK
 */
	Configure::write('Error', array(
	  'handler' => 'ErrorHandler::handleError',
	  'level' => E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED,
	  'trace' => true
	  ));


/**
 * Forced AppError Handler handler
 * 
 * IMPORTANT : This is deprecated and will be removed  on July 15, 2014 (put here on June 15, 2014) - RK
 */
	App::uses('AppErrorHandler', 'Lib/Error');
	Configure::write('Exception', array(
	  'handler' => 'AppErrorHandler::handleException',
	  'renderer' => 'AppExceptionRenderer',
	  'log' => true
	  ));

/**
 * We need to implement our own acl check.
 */
	Configure::write('Acl.classname', 'ZuhaAcl');

/**
 * File cache when working locally, then APC, and finally try Memcache.  Defaults to File.
 * 
 */
	if (php_sapi_name() === 'cli' || $_SERVER["REMOTE_ADDR"] === '127.0.0.1') {
	    $engine = 'File';
	} elseif (extension_loaded('apc') && (php_sapi_name() !== 'cli' || ini_get('apc.enable_cli'))) {
	    $engine = 'Apc';
	} elseif (extension_loaded('memcache')) {
	    $engine = 'Memcache';
	}
	$engine = isset($engine) ? $engine : 'File';
	
	Cache::config('default', array(
	 	'engine' => $engine, //[required]
	 	'duration'=> 3600, //[optional]
	 	'probability'=> 100, //[optional]
	 	'prefix' => Inflector::slug($prefix) . '_', //[optional]  prefix every cache file with this string
	 	));
	
	// In development mode, caches should expire quickly.
	$duration = '+90 days';
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
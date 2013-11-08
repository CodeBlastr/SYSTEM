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
	$prefix = Inflector::slug(SITE_DIR);
} else {
	// we are installing a new site here
	// OR using the cake console
	if (php_sapi_name() !== 'cli') {
	    if ($_SERVER['REQUEST_URI'] != '/install/site') {
	        header('Location: /install/site'); // switch with line below to allow installs at a catchall
	        //header('Location: http://buildrr.com/');
	        break;
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


Configure::write('Error', array(
	'handler' => 'ErrorHandler::handleError',
	'level' => E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED,
	'trace' => true
	));
App::uses('AppErrorHandler', 'Lib/Error');
Configure::write('Exception', array(
	'handler' => 'AppErrorHandler::handleException',
	'renderer' => 'AppExceptionRenderer',
	'log' => true
	));

/**
 * Compress CSS output by removing comments, whitespace, repeating tags, etc.
 * This requires a/var/cache directory to be writable by the web server for caching.
 * and /vendors/csspp/csspp.php
 *
 * To use, prefix the CSS link URL with '/ccss/' instead of '/css/' or use HtmlHelper::css().
 */
	//Configure::write('Asset.filter.css', 'css.php');

/**
 * Plug in your own custom JavaScript compressor by dropping a script in your webroot to handle the
 * output, and setting the config below to the name of the script.
 *
 * To use, prefix your JavaScript link URLs with '/cjs/' instead of '/js/' or use JsHelper::link().
 */
	//Configure::write('Asset.filter.js', 'custom_javascript_output_filter.php');

/**
 * The class name and database used in CakePHP's
 * access control lists.
 */
	Configure::write('Acl.classname', 'ZuhaAcl');
	Configure::write('Acl.database', 'default');

/**
 *
 * APC (http://pecl.php.net/package/APC)
 *
 * 	 Cache::config('default', array(
 *		'engine' => 'Apc', //[required]
 *		'duration' => 3600, //[optional]
 *		'probability' => 100, //[optional]
 * 		'prefix' => Inflector::slug(APP_DIR) . '_', //[optional]  prefix every cache file with this string
 *	));
 *
 * Xcache (http://xcache.lighttpd.net/)
 *
 * 	 Cache::config('default', array(
 *		'engine' => 'Xcache', //[required]
 *		'duration' => 3600, //[optional]
 *		'probability' => 100, //[optional]
 *		'prefix' => Inflector::slug(APP_DIR) . '_', //[optional] prefix every cache file with this string
 *		'user' => 'user', //user from xcache.admin.user settings
 *		'password' => 'password', //plaintext password (xcache.admin.pass)
 *	));
 *
 * Memcache (http://www.danga.com/memcached/)
 *
 * 	 Cache::config('default', array(
 *		'engine' => 'Memcache', //[required]
 *		'duration' => 3600, //[optional]
 *		'probability' => 100, //[optional]
 * 		'prefix' => Inflector::slug(APP_DIR) . '_', //[optional]  prefix every cache file with this string
 * 		'servers' => array(
 * 			'127.0.0.1:11211' // localhost, default port 11211
 * 		), //[optional]
 * 		'persistent' => true, // [optional] set this to false for non-persistent connections
 * 		'compress' => false, // [optional] compress data in Memcache (slower, but uses less memory)
 *	));
 */
 
$engine = 'File';
if(class_exists('Memcache')) {
	$engine = 'Memcache';
}
if (extension_loaded('apc') && (php_sapi_name() !== 'cli' || ini_get('apc.enable_cli'))) {
	$engine = 'Apc';
}

// In development mode, caches should expire quickly.
$duration = '+999 days';
if (Configure::read('debug') > 0) {
	$duration = '+10 seconds';
}
	
/**
 * Configure the cache used for general framework caching. Path information,
 * object listings, and translation cache files are stored with this configuration.
 */
Cache::config('_cake_core_', array(
	'engine' => $engine,
	'prefix' => $prefix . 'cake_core_',
	'path' => CACHE . 'persistent' . DS,
	'serialize' => ($engine === 'File'),
	'duration' => $duration
));

/**
 * Configure the cache for model and datasource caches. This cache configuration
 * is used to store schema descriptions, and table listings in connections.
 */
Cache::config('_cake_model_', array(
	'engine' => $engine,
	'prefix' => $prefix . 'cake_model_',
	'path' => CACHE . 'models' . DS,
	'serialize' => ($engine === 'File'),
	'duration' => $duration
));

<?php
if (file_exists(ROOT.DS.SITE_DIR.DS.'Config'.DS.'bootstrap.php')) :
	require_once(ROOT.DS.SITE_DIR.DS.'Config'.DS.'bootstrap.php');
else : 

/** 
 * Default bootstrap.php file from here down.
 */

require_once(ROOT.DS.APP_DIR.DS.'Config'.DS.'global.php');

/**
 * The settings below can be used to set additional paths to models, views and controllers.
 * This is related to Ticket #470 (https://trac.cakephp.org/ticket/470)
 *
 */
 
App::build(array(
	'plugins' => array(
		#ROOT.DS.SITE_DIR.DS.'Plugin'.DS,
		#ROOT.DS.SITE_DIR.DS.'plugins'.DS,
		ROOT.DS.APP_DIR.DS.'Plugin'.DS
		),
    'models' =>  array(
		#ROOT.DS.SITE_DIR.DS.'Model'.DS,
		#ROOT.DS.SITE_DIR.DS.'models'.DS,
		ROOT.DS.APP_DIR.DS.'Model'.DS
		),
    'views' => array(
		#ROOT.DS.SITE_DIR.DS.'View'.DS.'locale'.DS.Configure::read('Config.language').DS,
		#ROOT.DS.SITE_DIR.DS.'views'.DS.'locale'.DS.Configure::read('Config.language').DS,
		#ROOT.DS.SITE_DIR.DS.'View'.DS,
		#ROOT.DS.SITE_DIR.DS.'views'.DS,
		ROOT.DS.APP_DIR.DS.'View'.DS,
		),
	'controllers' => array(
		#ROOT.DS.SITE_DIR.DS.'Controller'.DS,
		#ROOT.DS.SITE_DIR.DS.'controllers'.DS,
		ROOT.DS.APP_DIR.DS.'Controller'.DS
		),
    'datasources' => array(
		#ROOT.DS.SITE_DIR.DS.'Model'.DS.'Datasource'.DS,
		#ROOT.DS.SITE_DIR.DS.'models'.DS.'datasources'.DS,
		ROOT.DS.APP_DIR.DS.'models'.DS.'datasources'.DS
		),
    'behaviors' => array(
		#ROOT.DS.SITE_DIR.DS.'Model'.DS.'Behavior'.DS,
		#ROOT.DS.SITE_DIR.DS.'models'.DS.'behaviors'.DS,
		ROOT.DS.APP_DIR.DS.'Model'.DS.'Behavior'.DS
		),
    'components' => array(
		#ROOT.DS.SITE_DIR.DS.'Controller'.DS.'Component'.DS,
		#ROOT.DS.SITE_DIR.DS.'controllers'.DS.'components'.DS,
		ROOT.DS.APP_DIR.DS.'Controller'.DS.'Component'.DS
		),
    'helpers' => array(
		#ROOT.DS.SITE_DIR.DS.'View'.DS.'Helper'.DS,
		#ROOT.DS.SITE_DIR.DS.'views'.DS.'helpers'.DS,
		ROOT.DS.APP_DIR.DS.'View'.DS.'Helper'.DS
		),
#   'vendors' => array('/full/path/to/vendors/', '/next/full/path/to/vendors/'),
#   'shells' => array('/full/path/to/shells/', '/next/full/path/to/shells/'),
#   'locales' => array('/full/path/to/locale/', '/next/full/path/to/locale/')
));
/**
 * As of 1.3, additional rules for the inflector are added below
 *
 * Inflector::rules('singular', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 * Inflector::rules('plural', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 *
 */
	
	function __setConstants($path = null, $return = false) {
		$path = (!empty($path) ? $path : CONFIGS);
		if (file_exists($path .'settings.ini')) {
			$path .= 'settings.ini';
		} else {
			$path .= 'defaults.ini';
		}
		$settings = parse_ini_file($path, true);
		
		if ($return == true) {
			$settings = my_array_map($settings, 'parse_ini_ini');
			return $settings;
		} else {
			foreach ($settings as $key => $value) {				
				if (!defined(strtoupper($key))) {
					if (is_array($value)) {
						define(strtoupper($key), serialize($value));
					} else {
						define(strtoupper($key), $value);
					}
				}
			}
		}
		#debug(get_defined_constants());
	}
	
	__setConstants();

	/**
	 * Plugins need to be loaded manually, you can either load them one by one or all of them in a single call
	 * Uncomment one of the lines below, as you need. make sure you read the documentation on CakePlugin to use more
	 * advanced ways of loading plugins
	 * 
	 * CakePlugin::load('DebugKit'); //Loads a single plugin named DebugKit
	 */
	 CakePlugin::loadAll(); // Loads all plugins at once

endif;
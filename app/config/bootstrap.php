<?php
/**
 * This file is loaded automatically by the app/webroot/index.php file after the core bootstrap.php
 *
 * This is an application wide file to load any function that is not used within a class
 * define. You can also use this to include or require any files in your application.
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
 * @subpackage    cake.app.config
 * @since         CakePHP(tm) v 0.10.8.2117
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * Custom file for loading functions which are available to multi-sites.
 */
 require_once(ROOT.DS.'app'.DS.'config'.DS.'global.php');

/**
 * The settings below can be used to set additional paths to models, views and controllers.
 * This is related to Ticket #470 (https://trac.cakephp.org/ticket/470)
 *
 */
 
App::build(array(
	'plugins' => array(
		ROOT.DS.APP_DIR.DS.'plugins'.DS,
		ROOT.DS.APP_DIR.DS.'Plugin'.DS,
		ROOT.DS.'app'.DS.'Plugin'.DS
		),
    'models' =>  array(
		ROOT.DS.APP_DIR.DS.'models'.DS,
		ROOT.DS.APP_DIR.DS.'Model'.DS,
		ROOT.DS.'app'.DS.'Model'.DS
		),
    'views' => array(
		ROOT.DS.APP_DIR.DS.'views'.DS.'locale'.DS.Configure::read('Config.language').DS,
		ROOT.DS.APP_DIR.DS.'View'.DS.'locale'.DS.Configure::read('Config.language').DS,
		ROOT.DS.APP_DIR.DS.'views'.DS,
		ROOT.DS.APP_DIR.DS.'View'.DS,
		ROOT.DS.'app'.DS.'View'.DS,
		),
	'controllers' => array(
		ROOT.DS.APP_DIR.DS.'controllers'.DS,
		ROOT.DS.APP_DIR.DS.'Controller'.DS,
		ROOT.DS.'app'.DS.'Controller'.DS
		),
	'libs' => array(
		ROOT.DS.APP_DIR.DS.'lib'.DS,
		ROOT.DS.APP_DIR.DS.'Lib'.DS,
		ROOT.DS.'app'.DS.'Lib'.DS
		),
    'datasources' => array(
		ROOT.DS.APP_DIR.DS.'models'.DS.'datasources'.DS,
		ROOT.DS.'app'.DS.'models'.DS.'datasources'.DS
		),
    'behaviors' => array(
		ROOT.DS.APP_DIR.DS.'models'.DS.'behaviors'.DS,
		ROOT.DS.APP_DIR.DS.'Model'.DS.'Behavior'.DS,
		ROOT.DS.'app'.DS.'Model'.DS.'Behavior'.DS
		),
    'components' => array(
		ROOT.DS.APP_DIR.DS.'controllers'.DS.'components'.DS,
		ROOT.DS.APP_DIR.DS.'Controller'.DS.'Component'.DS,
		ROOT.DS.'app'.DS.'Controller'.DS.'Component'.DS
		),
    'helpers' => array(
		ROOT.DS.APP_DIR.DS.'views'.DS.'helpers'.DS,
		ROOT.DS.APP_DIR.DS.'View'.DS.'Helper'.DS,
		ROOT.DS.'app'.DS.'View'.DS.'Helper'.DS
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
		$path = (!empty($path) ? $path : dirname(__FILE__) . DS);
		
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
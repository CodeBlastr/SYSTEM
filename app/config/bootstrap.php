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
 * The settings below can be used to set additional paths to models, views and controllers.
 * This is related to Ticket #470 (https://trac.cakephp.org/ticket/470)
 *
 */
 
App::build(array(
	'plugins' => array(
		$_SERVER['DOCUMENT_ROOT'].DS.APP_DIR.DS.'plugins'.DS,
		$_SERVER['DOCUMENT_ROOT'].DS.'app'.DS.'plugins'.DS
		),
    'models' =>  array(
		$_SERVER['DOCUMENT_ROOT'].DS.APP_DIR.DS.'models'.DS,
		$_SERVER['DOCUMENT_ROOT'].DS.'app'.DS.'models'.DS
		),
    'views' => array(
		$_SERVER['DOCUMENT_ROOT'].DS.APP_DIR.DS.'views'.DS,
		$_SERVER['DOCUMENT_ROOT'].DS.'app'.DS.'views'.DS
		),
	'controllers' => array(
		$_SERVER['DOCUMENT_ROOT'].DS.APP_DIR.DS.'controllers'.DS,
		$_SERVER['DOCUMENT_ROOT'].DS.'app'.DS.'controllers'.DS
		),
    'datasources' => array(
		$_SERVER['DOCUMENT_ROOT'].DS.APP_DIR.DS.'models'.DS.'datasources'.DS,
		$_SERVER['DOCUMENT_ROOT'].DS.'app'.DS.'models'.DS.'datasources'.DS
		),
    'behaviors' => array(
		$_SERVER['DOCUMENT_ROOT'].DS.APP_DIR.DS.'models'.DS.'behaviors'.DS,
		$_SERVER['DOCUMENT_ROOT'].DS.'app'.DS.'models'.DS.'behaviors'.DS
		),
    'components' => array(
		$_SERVER['DOCUMENT_ROOT'].DS.APP_DIR.DS.'controllers'.DS.'components'.DS,
		$_SERVER['DOCUMENT_ROOT'].DS.'app'.DS.'controllers'.DS.'components'.DS
		),
    'helpers' => array(
		$_SERVER['DOCUMENT_ROOT'].DS.APP_DIR.DS.'views'.DS.'helpers'.DS,
		$_SERVER['DOCUMENT_ROOT'].DS.'app'.DS.'views'.DS.'helpers'.DS
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

	
	
	function print_rReverse($in) {
   		$lines = explode("\n", trim($in));
		if (trim($lines[0]) != 'Array') {
	        // bottomed out to something that isn't an array
	        return $in;
    	} else {
        	// this is an array, lets parse it
	        if (preg_match("/(\s{5,})\(/", $lines[1], $match)) {
	            // this is a tested array/recursive call to this function
	            // take a set of spaces off the beginning
	            $spaces = $match[1];
	            $spaces_length = strlen($spaces);
	            $lines_total = count($lines);
	            for ($i = 0; $i < $lines_total; $i++) {
	                if (substr($lines[$i], 0, $spaces_length) == $spaces) {
	                    $lines[$i] = substr($lines[$i], $spaces_length);
	                }
	            }
	        }
	        array_shift($lines); // Array
	        array_shift($lines); // (
	        array_pop($lines); // )
	        $in = implode("\n", $lines);
	        // make sure we only match stuff with 4 preceding spaces (stuff for this array and not a nested one)
	        preg_match_all("/^\s{4}\[(.+?)\] \=\> /m", $in, $matches, PREG_OFFSET_CAPTURE | PREG_SET_ORDER);
	        $pos = array();
	        $previous_key = '';
	        $in_length = strlen($in);
	        // store the following in $pos:
	        // array with key = key of the parsed array's item
	        // value = array(start position in $in, $end position in $in)
	        foreach ($matches as $match) {
	            $key = $match[1][0];
	            $start = trim($match[0][1]) + strlen($match[0][0]);
	            $pos[$key] = array($start, $in_length);
	            if ($previous_key != '') $pos[$previous_key][1] = $match[0][1] - 1;
	            $previous_key = $key;
	        }
	        $ret = array();
	        foreach ($pos as $key => $where) {
	            // recursively see if the parsed out value is an array too
	            $ret[$key] = print_rReverse(substr($in, $where[0], $where[1] - $where[0]));
				if (!is_array($ret[$key])) {
					$ret[$key] = trim($ret[$key]);
				}
	        }
	        return $ret;
	    }
	}
	
	function elementSettings($string) {
		$return = array();
		$vars = explode(',', $string);
		foreach ($vars as $var) {
			$var = explode('.', $var);
			$set[$var[0]] = $var[1];
			$return = array_merge($return, $set);
		}
		return $return;
	}
	
?>
<?php
/**
 * Sites Bootstrap
 *
 * Zuha is capable of hosting an unlimited number of sites from a single install. By editing the /sites/bootstrap.php file and telling it which domain resolve to which sites folder you can use the core app files and over write any core app files from within the site folder so that you can host multiple sites and yet still have full customization of each site.
 * 
 * Example : 
 * $domains['domain.localhost'] = 'domain.com';
 * $domains['dev.domain.com'] = 'domain.com';
 * $domains['www.domain.com'] = 'domain.com';
 * $domains['domain.com'] = 'domain.com';
 * 
 * Where $domains equals a key => value array where the key is the actual address that will appear in the browser address bar, and the value is the name of the folder in the sites directory which holds the site configuration and customization. 
 *
 * PHP versions 5.3
 *
 * Zuha(tm) : Web Development Suite (http://zuha.com)
 * Copyright 2009-2012, Zuha.com (http://zuha.com)
 *
 * Licensed under GNU General Public License version 3 http://www.gnu.org/licenses/gpl.html
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2009-2012, Zuha.com (http://zuha.com)
 * @link          http://zuha.com Zuha
 * @package       zuha
 * @subpackage    sites
 * @since         Zuha(tm) v 0.0.0
 * @license       GNU General Public License version 3 (http://www.gnu.org/licenses/gpl.html)
 */

$domains['example.localhost'] = 'example.com';
$domains['dev.example.com'] = 'example.com';
$domains['www.example.com'] = 'example.com';
$domains['example.com'] = 'example.com';

/** end **/

if (!empty($domains[$_SERVER['HTTP_HOST']])) {
	if (!defined('SITE_DIR')) {
		// this is the site combined local and remote sites directory
		define('SITE_DIR', 'sites' . DS . $domains[$_SERVER['HTTP_HOST']]);
	}
}
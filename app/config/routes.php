<?php
/* SVN FILE: $Id$ */
/**
 * Short description for file.
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
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
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/views/pages/home.ctp)...
 */
 	Router::connect('/', array('controller' => 'pages', 'action' => 'display', 'home'));
#	Router::connect('/ajax_delete', array('controller' => 'pages', 'action' => 'display', 'ajax_delete'));
#	Router::connect('/ajax_edit', array('controller' => 'pages', 'action' => 'display', 'ajax_edit'));
#	Router::connect('/ajax_update', array('controller' => 'pages', 'action' => 'display', 'ajax_update'));
#	Router::connect('/ajax_complete', array('controller' => 'pages', 'action' => 'display', 'ajax_complete'));
#	Router::connect('/edit_types', array('controller' => 'pages', 'action' => 'display', 'edit_types'));
#	Router::connect('/add_tags', array('controller' => 'pages', 'action' => 'display', 'add_tags'));
	
#	Router::connect('/admin_index', array('controller' => 'pages', 'action' => 'display', 'admin_index'));
	Router::parseExtensions('json');
/**
 * ...and connect the rest of 'Pages' controller's urls.
 */
 
	Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));
	/*
	# shorten up plugin urls
	$controllerKey = false;
	$prefixedPluginKey = false;
	$urlPieces = explode('/', $fromUrl);
	$plugins = App::objects('plugin');
	$pluginKey = array_search(Inflector::camelize($urlPieces[0]), $plugins);
	if (!empty($urlPieces[1])) $prefixedPluginKey = array_search(Inflector::camelize($urlPieces[1]), $plugins);
	# lets do non-admin or prefixed first
	if ($pluginKey !== false) {
		# and check if the next url piece is a controller or an action or if it even exists
		$plugin = strtolower($plugins[$pluginKey]);
		if (!empty($urlPieces[0])) {
			$pluginPath = App::pluginPath($plugin);
			$controllers = App::objects('controller', $pluginPath.'controllers');
			$controllerKey = array_search(Inflector::camelize($urlPieces[1]), $controllers);
			if ($controllerKey !== false) {
				$controller = $controllers[$controllerKey];
				Router::Connect('/'.$plugin.'/:controller/:action/*', array('plugin' => $plugin, 'controller' => $controller));
			} else {
				$controller = $plugin;
				Router::Connect('/'.$plugin.'/:action/*', array('plugin' => $plugin, 'controller' => $controller));
			}
		}	
	} else if ($prefixedPluginKey !== false) {
		# now lets do admin
		$plugin = strtolower($plugins[$prefixedPluginKey]);
		if ($urlPieces[0] == 'admin') {
			$pluginPath = App::pluginPath($plugin);
			$controllers = App::objects('controller', $pluginPath.'controllers');
			if(!empty($urlPieces[2])) $controllerKey = array_search(Inflector::camelize($urlPieces[2]), $controllers);
			if ($controllerKey !== false) {
				$controller = $controllers[$controllerKey];
				Router::Connect('/admin/'.$plugin.'/:controller/:action/*', array('plugin' => $plugin, 'controller' => $controller, 'admin'=> true));
			} else {
				$controller = $plugin;
				Router::Connect('/admin/'.$plugin.'/:action/*', array('plugin' => $plugin, 'controller' => $controller, 'admin'=> true));
			}
		}
	} */
	#App::import('Lib', 'HtmlLinkRewrite');
	# yeah I know this isn't 100% right, but it works for some things
	# I've seen it not work is when you're in 
	# the second level of a plugin and linking back to the first level  of that plugin
	# ie. Your in /contacts/contact_people and linking back to /contacts
	# and also when you link to an index of a plugin without specifying index.
	# ie. /forums or /tickets
	#Router::connect('/:plugin', array(), array('routeClass' => 'HtmlLinkRewrite'));
	#Router::connect('/:plugin', array(), array('routeClass' => 'HtmlLinkRewrite'));
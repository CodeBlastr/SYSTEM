<?php
/**
 * Custom Routes
 *
 * Used for routing access requests to the correct file resource.
 *
 * PHP versions 5
 *
 * Zuha(tm) : Business Management Applications (http://zuha.com)
 * Copyright 2009-2010, Zuha Foundation Inc. (http://zuhafoundation.org)
 *
 * Licensed under GPL v3 License
 * Must retain the above copyright notice and release modifications publicly.
 *
 * @copyright     Copyright 2009-2010, Zuha Foundation Inc. (http://zuha.com)
 * @link          http://zuha.com Zuha™ Project
 * @package       zuha
 * @subpackage    zuha.app.config
 * @since         Zuha(tm) v 0.0.1
 * @license       GPL v3 License (http://www.gnu.org/licenses/gpl.html) and Future Versions
 */
 	Router::connect('/', array('controller' => 'pages', 'action' => 'display', 'home'));
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
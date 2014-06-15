<?php

/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */
 	//Router::connect('/', array('controller' => '', 'home'));
	Router::parseExtensions('rss', 'xml', 'json', 'cal', 'csv');
/**
 * Load all plugin routes.  See the CakePlugin documentation on 
 * how to customize the loading of plugin routes.
 */
	CakePlugin::routes();
	
/**
 * Custom site routing goes inside of the custom routes file
 * 
 * IMPORTANT : The order of this to the require of Cake/routes.php is important
 */
if (file_exists(ROOT.DS.SITE_DIR.DS.'Config'.DS.'routes.php')) {
	require_once(ROOT.DS.SITE_DIR.DS.'Config'.DS.'routes.php');
}

/**
 * Here we map resourse for rest api calls
 * @todo We need to make this more dynamic. Currently
 * 		this supports a custom plugin, but should be 
 * 		make to support all plugins, or the plugins
 * 		that require it.
 */
Router::mapResources('Reports.ReportPages');

/**
 * Load the CakePHP default routes. Remove this if you do not want to use
 * the built-in default routes.
 */ 
	require CAKE . 'Config' . DS . 'routes.php';
<?php
/**
 * Webpages Breadcrumb Element 
 *
 * Used to display a bread crumbs navigation element, based on directory structure. 
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
 * @subpackage    zuha.app.plugins.forms.views.elements
 * @since         Zuha(tm) v 0.0.1
 * @license       GPL v3 License (http://www.gnu.org/licenses/gpl.html) and Future Versions
 * @todo		  We need to use the standard element header which is commented out below.  It allows more options than just separator to be put in.  
 * @todo		  We need to put defaults into this file.  We should specify the separator default and have that over written if the variable exists.
 * @todo:   	  Create a homepage setting, which we can use here to find out if we're on the homepage.  This homepage setting should be 
 */
?>
<?php
// this should be at the top of every element created with format __ELEMENT_PLUGIN_ELEMENTNAME_instanceNumber.
// it allows a database driven way of configuring elements, and having multiple instances of that configuration.
	/*if(!empty($instance) && defined('__ELEMENT_WEBPAGES_BREADCRUMB_'.$instance)) {
		extract(unserialize(constant('__ELEMENT_WEBPAGES_BREADCRUMB_'.$instance)));
	} else if (defined('__ELEMENT_WEBPAGES_BREADCRUMB')) {
		extract(unserialize(__ELEMENT_WEBPAGES_BREADCRUMB));
	} */
?>
<?php $home = $this->Html->link('Home ', '/');?>
<?php if(defined('__ELEMENT_WEBPAGES_BREADCRUMB')) {
	 	$home .= __ELEMENT_WEBPAGES_BREADCRUMB . ' ';
} 
// @todo: find home page from setting and pass the reset here.?>
<?php if($_SERVER['REQUEST_URI'] == '/') {
  $crumb->getHtml(' ', 'reset') ;
} else {?>
<?php
	$raw_url = trim($_SERVER['REQUEST_URI'], '/');
	$urls = explode('/', $raw_url);
		echo $home;
	
	// urls if in form of /controller/index or /plugin/controller means they belong to index pages.
	// so count will be max of 3 in that case
	
	if ( count($urls)  < 2 || $this->request->params['action'] == 'index' )  {
		if (defined('__ELEMENT_BREADCRUMBS_SEPARATOR'))
			echo  __ELEMENT_BREADCRUMBS_SEPARATOR. ' ';
		$humanCtrl = Inflector::humanize(Inflector::underscore($this->request->params['controller'])); #Contact People
	
	   echo $crumb->getHtml($humanCtrl, 'reset') ;
	} else {
		if (defined('__ELEMENT_BREADCRUMBS_SEPARATOR'))
			echo  __ELEMENT_BREADCRUMBS_SEPARATOR. ' ';
		
	   echo ucfirst($crumb->getHtml($this->request->params['action'], null, 'auto') );
	}
}
?>
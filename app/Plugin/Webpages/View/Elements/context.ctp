<?php
/**
 * Context Element
 *
 * Use for displaying webpages when they match the context.  Is called using the template tag {element: webpages.context.1}  (where 1 is the instance of the element you are looking to call)  Note, the settings for the instance are located in the settings database table.
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
 */
?>
<?php 
// this should be at the top of every element created with format __ELEMENT_PLUGIN_ELEMENTNAME_instanceNumber.
// it allows a database driven way of configuring elements, and having multiple instances of that configuration.
	if(!empty($instance) && defined('__ELEMENT_WEBPAGES_CONTEXT_'.$instance)) {
		extract(unserialize(constant('__ELEMENT_WEBPAGES_CONTEXT_'.$instance)));
	}	
	# check against url context
	$i = 0;
	if (!empty($url)) { foreach($url as $u) {
		# check each one against the current url
		$u = str_replace('/', '\/', $u);
		$urlRegEx = '/'.str_replace('*', '(.*)', $u).'/';
		if (preg_match($urlRegEx, $this->request->url)) {
			$page = $pageId[$i];
 			$contextWebpages[] = $this->requestAction('/webpages/webpages/view/'.$page);
		}
		$i++;
	}}	
	
	# check against user role context
	$i = 0;
	if (!empty($userRoleId)) { foreach($userRoleId as $u) {
		$actualUserRole = $this->Session->read('Auth.User.user_role_id') ? $this->Session->read('Auth.User.user_role_id') : __SYSTEM_GUESTS_USER_ROLE_ID;
		if ($u == $actualUserRole) {
			$page = $pageId[$i];
 			$contextWebpages[] = $this->requestAction('/webpages/webpages/view/'.$page);
		}
		$i++;
	}}

	
	
	if (!empty($contextWebpages)) { 
		foreach ($contextWebpages as $webpage) {
			preg_match_all ("/(\{var:([^\}\{]*)([0-9]*)([^\}\{]*)\})/", $webpage["Webpage"]["content"], $matches);
			if (!empty($matches[2][0])) {
				mb_parse_str($matches[2][0], $match);
				$outputVar = ZuhaSet::array_intersect_r($___dataForView, $match);
				$i = 0;
				foreach ($matches[0] as $varMatch) {
					$varMatch = trim($varMatch);
					#str_replace(search, replace, subject);
					$webpage["Webpage"]["content"] = str_replace($varMatch, $outputVar, $webpage['Webpage']['content']);
					$i++;
				}		
			}
		}
		echo $webpage['Webpage']['content'];
	} else {
		# echo 'context element displaying nothing';
	}
	
?>
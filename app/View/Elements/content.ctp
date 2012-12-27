<?php
$flash_for_layout = $this->Session->flash();
$flash_auth_for_layout = $this->Session->flash('auth');
if (!empty($defaultTemplate)) {
	
	// matches helper template tags like {helper: content_for_layout}
	preg_match_all ("/(\{helper: ([az_]*)([^\}\{]*)\})/", $defaultTemplate["Webpage"]["content"], $matches);
	$i = 0;
	foreach ($matches[0] as $helperMatch) {
		$helper = trim($matches[3][$i]);
		$defaultTemplate["Webpage"]["content"] = str_replace($helperMatch, $$helper, $defaultTemplate['Webpage']['content']);
		$i++;
	}
	
	#skiping the parsing of text area content with this check	
	preg_match_all ("/(<textarea[^>]+>)(.*)(<\/textarea>)/isU", $defaultTemplate["Webpage"]["content"], $matchesEditable);
	
	$nonParseable = array();
	
	$i = 0;
	foreach($matchesEditable[2] as $matchEditable)	{
		if(trim($matchEditable))	{
			$nonParseable['[PLACEHOLDER:'.$i.']'] = $matchEditable;
			$defaultTemplate["Webpage"]["content"] = str_replace($matchEditable, '[PLACEHOLDER:'.$i.']', $defaultTemplate['Webpage']['content']);
			$i++;
		}		
	}
	
	// matches element template tags like {element: plugin.name.instance} for example {element: contacts.recent.2}
	preg_match_all ("/(\{element: ([az_]*)([^\}\{]*)\})/", $defaultTemplate["Webpage"]["content"], $matches);

	$i=0; 
	foreach ($matches[0] as $elementMatch) {
		$element = trim($matches[3][$i]);
		if (preg_match('/([a-zA-Z0-9_\.]+)([a-zA-Z0-9_]+\.[0-9]+)/', $element)) {
			# means there is an instance number at the end
			$element = explode('.', $element);
			# these account for the possibility of a plugin or no plugin
			$instance = !empty($element[2]) ? $element[2] : $element[1]; 
			$plugin = !empty($element[2]) ? $element[0] : null;
			$element = !empty($element[2]) ? $element[1] : $element[0];
		} else if (strpos($element, '.')) {
			# this is used to handle non plugin elements with no instance number in the tag
			$element = explode('.', $element);  
			$plugin = $element[0];
			$element = $element[1];  
		}
		# removed cache for forms, because you can't set it based on form inputs
		# $elementCfg['cache'] = (!empty($userId) ? array('key' => $userId.$element, 'time' => '+2 days') : null);
		$elementPlugin['plugin'] = (!empty($plugin) ? $plugin : null);
		$elementCfg['instance'] = (!empty($instance) ? $instance : null);
		$defaultTemplate["Webpage"]["content"] = str_replace($elementMatch, $this->element($element, $elementCfg, $elementPlugin), $defaultTemplate['Webpage']['content']); 
		$i++;
	}
	
	# matches form template tags {form: Id/type} for example {form: 1/edit}
	preg_match_all ("/(\{form: ([az_]*)([^\}\{]*)\})/", $defaultTemplate["Webpage"]["content"], $matches);
	$i = 0;
	foreach ($matches[0] as $formMatch) {
		$formCfg['id'] = trim($matches[3][$i]);
		# removed cache for forms, because you can't set it based on form inputs
		# $formCfg['cache'] = array('key' => 'form-'.$formCfg['id'], 'time' => '+2 days');
		$defaultTemplate["Webpage"]["content"] = str_replace($formMatch, $this->element('forms', $formCfg, array('plugin' => 'forms')), $defaultTemplate['Webpage']['content']);
		$i++;
	}
	
	# matches menu template tags like {menu: Id} for example {menu: 3}
	preg_match_all ("/(\{menu: ([az_]*)([^\}\{]*)\})/", $defaultTemplate["Webpage"]["content"], $matches);
	$i = 0;
	foreach ($matches[0] as $menuMatch) {
		$menuCfg['id'] = trim($matches[3][$i]);
		# removed cache temporarily
		# $menuCfg['cache'] = array('key' => 'menu-'.$menuCfg['id'], 'time' => '+999 days');
		$menuCfg['plugin'] = 'menus';
		$defaultTemplate['Webpage']['content'] = str_replace($menuMatch, $this->element('Webpages.menus', $menuCfg), $defaultTemplate['Webpage']['content']);
		$i++;
	}
	
	#checking for the textarea content placeholders	
	foreach($nonParseable as $placeHolder=>$holdingContent)	{
		$defaultTemplate["Webpage"]["content"] = str_replace($placeHolder, $holdingContent, $defaultTemplate['Webpage']['content']);
	}
	
	# display the database driven default template
	echo $defaultTemplate['Webpage']['content'];
} else {
	echo $this->Session->flash(); 
    echo $this->Session->flash('auth');
	echo $content_for_layout;
}

echo $this->Element('modal_editor', array(), array('plugin' => 'webpages')); ?>
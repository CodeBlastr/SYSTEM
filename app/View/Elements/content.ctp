<?php
/**
 * Content element
 * Handles template tag parsing. 
 * 
 * Note: for configurable templates, you have to expect that config and element tags should be block elements.  (Inline elements make a mess)
 * 
 * @todo turn other tags into functions too
 */
$flash_for_layout = $this->Session->flash();
$flash_auth_for_layout = $this->Session->flash('auth');

if (!empty($defaultTemplate)) {
	
	// just shortening the variable name
	$content = $defaultTemplate["Webpage"]["content"];
	
	
	// matches helper template tags like {helper: content_for_layout}
	preg_match_all ("/\{helper: (.*?)\}/", $content, $matches);
	$i = 0;
	foreach ($matches[0] as $helperMatch) {
		$helper = trim($matches[1][$i]);
		$content = str_replace($helperMatch, $$helper, $content);
		$i++;
	}
	
	// configurable template settings ex. {config: 0}
	$modelName = Inflector::classify($this->request->controller);
	$_layout = !empty($_layout[0]) ? $_layout[0] : !empty($_layout) ? $_layout : null; // takes care of $Model->data results which are set in AppModel afterfind()
	if (!empty($_layout[$modelName]['_layout'])) {
		$templateFile = ROOT.DS.SITE_DIR.DS.'Locale'.DS.'View'.DS.'Layouts'.DS.$_layout[$modelName]['_layout'].'.ctp';
		if (file_exists($templateFile)) {
			// split up the template contents into settings and content
			$templateContents = preg_split('/\?>/s', file_get_contents($templateFile));
			$searches = array('<?php', '/**', 'Default Settings', ' * ', ' */');
			// get default settings from the top of the template file.  Example settings format in ThemeableBehavior
			$fileDefaults = parse_ini_string(trim(str_replace($searches, '', $templateContents[0])));
			$fileDefaults['actions'] = !empty($fileDefaults['actions']) ? $fileDefaults['actions'] : array('view');
			// default override settings from the database are set here	
			$settings = !empty($_layout[$modelName]['_layoutSettings']) ? unserialize($_layout[$modelName]['_layoutSettings']) : array('actions' => array('view'));
			$settings['elements'] = !empty($settings['elements']) ? $settings['elements'] + $fileDefaults['elements'] : $fileDefaults['elements'];
			$settings['actions'] = !empty($settings['actions']) ? $settings['actions'] + $fileDefaults['actions'] : $fileDefaults['actions'];
			$actionMatch = in_array($this->request->action, $settings['actions']);
			if ($actionMatch === true) { // test if we're in a good action to apply the template to
				// add the drag and drop javascript (order is important)
				$content = !empty($templateEditing) ? str_replace('</head>', "    {element: templates/edit}".PHP_EOL."</head>", trim($templateContents[1])) : trim($templateContents[1]);
				// first pass a {element x} template tags so that non {config: x} get replaced first (required for editing config)
				$content = $this->Html->tagElement($this, $content);
				preg_match_all("/(\{config: ([az_]*)([^\}\{]*)\})/", $content, $configMatches);
				$i = 0;
				foreach ($configMatches[0] as $configMatch) {
					$replacement = $settings['elements'][trim($configMatches[3][$i])];
					$replacement = !empty($templateEditing) ?  sprintf('<ul id="config%s" data-template-tag="config: %s"> %s </ul>', $i, $i, $replacement) : $replacement;
					$content = str_replace($configMatch, $replacement, $content);
					unset($replacement);
					$i++;
				}
			}
		}
	}


	// replace the element tags again (if templateEditing is on it's a configurable template, and has already the old {element: x} tags replaced)
	$elementOptions = !empty($templateEditing) ? array('templateEditing' => true) : null;
	$content = $this->Html->tagElement($this, $content, $elementOptions);
	//$content =  $this->Html->link('incontnet');
	
	// skipping the parsing of text area content with this check	
	preg_match_all ("/(<textarea[^>]+>)(.*)(<\/textarea>)/isU", $content, $matchesEditable);
	$nonParseable = array();
	$i = 0;
	foreach($matchesEditable[2] as $matchEditable)	{
		if(!is_numeric($matchEditable))	{
			$nonParseable['[PLACEHOLDER:'.$i.']'] = $matchEditable;
			$content = str_replace($matchEditable, '[PLACEHOLDER:'.$i.']', $content);
			$i++;
		}		
	}
	
	// matches form template tags {form: Id/type} for example {form: 1/edit}
	preg_match_all ("/(\{form: ([az_]*)([^\}\{]*)\})/", $content, $matches);
	$i = 0;
	foreach ($matches[0] as $formMatch) {
		$formCfg['id'] = trim($matches[3][$i]);
		// removed cache for forms, because you can't set it based on form inputs
		// $formCfg['cache'] = array('key' => 'form-'.$formCfg['id'], 'time' => '+2 days');
		$content = str_replace($formMatch, $this->element('Forms.forms', $formCfg), $content);
		$i++;
	}
	
	// matches form template tags {answer: Id} for example {answer: 1}
	preg_match_all ("/(\{answer: ([az_]*)([^\}\{]*)\})/", $content, $matches);
	$i = 0;
	foreach ($matches[0] as $answerMatch) {
		$answerCfg['id'] = trim($matches[3][$i]);
		$content = str_replace($answerMatch, $this->element('Answers.answer', $answerCfg), $content);
		$i++;
	}
	
	// matches gallery template tags {gallery: Id} for example {gallery: 28749283}
	preg_match_all ("/(\{gallery: ([az_]*)([^\}\{]*)\})/", $content, $matches);
	$i = 0;
	foreach ($matches[0] as $galleryMatch) {
		$galleryCfg['foreignKey'] = trim($matches[3][$i]);
		// removed cache for forms, because you can't set it based on form inputs
		// $formCfg['cache'] = array('key' => 'form-'.$formCfg['id'], 'time' => '+2 days');
		$content = str_replace($galleryMatch, $this->element('gallery', $galleryCfg, array('plugin' => 'galleries')), $content);
		$i++;
	}
	
	// matches menu template tags like {menu: Id} for example {menu: 3}
	// This mysteriously broke. I replaced it with what seems to be a good regex.
	// For some reason, the old regex started chopping off the first letter of the match.
	// If other regex's in this file start acting up, try using this new regex. ^JB
	//preg_match_all ("/(\{menu: ([az_]*)([^\}\{]*)\})/", $content, $matches);
	preg_match_all ("/\{menu: (.*?)\}/", $content, $matches2);
	$i = 0;
	foreach ($matches2[0] as $menuMatch) {
		$menu = $this->Html->parseTag(trim($matches2[1][$i]));
		$vars = array('id' => $menu['name']) + $menu['variables'];
		// removed cache temporarily
		// $menuCfg['cache'] = array('key' => 'menu-'.$menuCfg['id'], 'time' => '+999 days');
		$content = str_replace($menuMatch, $this->Element('Webpages.menus', $vars), $content);
		$i++;
	}

	// checking for the textarea content placeholders	
	foreach($nonParseable as $placeHolder=>$holdingContent)	{
		$content = str_replace($placeHolder, $holdingContent, $content);
	}
	
	// display the database driven default template
	echo $content;
} else {
	// need a comment about when we ever get to this
	echo $this->Session->flash(); 
    echo $this->Session->flash('auth');
	echo $content_for_layout;
}

if($adminbar) {
	echo $this->Element('Webpages.editor', array());
}


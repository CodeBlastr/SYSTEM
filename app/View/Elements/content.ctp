<?php
$flash_for_layout = $this->Session->flash();
$flash_auth_for_layout = $this->Session->flash('auth');
if (!empty($defaultTemplate)) {
	
	// configurable template settings ex. {config: 0}
	$modelName = Inflector::classify($this->request->controller);
	$_layout = !empty($_layout[0]) ? $_layout[0] : $_layout; // takes care of $Model->data results which are set in AppModel afterfind()
	if (!empty($_layout[$modelName]['_layout'])) {
		$settings = !empty($_layout[$modelName]['_layoutSettings']) ? unserialize($_layout[$modelName]['_layoutSettings']) : array('settings' => array('actions' => array('view')));
		$actionMatch = in_array($this->request->action, $settings['settings']['actions']);
		$settings = $settings['settings'];

		if ($actionMatch === true) { // test if we're in a good action to apply the template to
			$templateFile = ROOT.DS.SITE_DIR.DS.'Locale'.DS.'View'.DS.'Layouts'.DS.$_layout[$modelName]['_layout'].'.ctp';
			if (file_exists($templateFile)) {
				$templateContents = preg_split('/\?>/s', file_get_contents($templateFile));
				$searches = array('<?php', '/**', 'Settings', ' * ', ' */');
				/** get default settings from the top of the template file.  Ex.
				<?php
				/**
				 * Settings
				 * elements[] = "config 0"
				 * elements[] = "config 1"
				 * elements[] = "config 2"
				 * / (remove space between * / and delete this paranthesis)
				?>
				*/
				$settings = !empty($settings['elements']) ? $settings : parse_ini_string(trim(str_replace($searches, '', $templateContents[0])));
				$defaultTemplate['Webpage']['content'] = trim($templateContents[1]);
				preg_match_all ("/(\{config: ([az_]*)([^\}\{]*)\})/", $defaultTemplate['Webpage']['content'], $configMatches);
				$i = 0;
				foreach ($configMatches[0] as $configMatch) {
					$replacement = $settings['elements'][trim($configMatches[3][$i])];
					$replacement = !empty($templateEditing) ?  sprintf('<div data-template-tag="config: %s">%s</div>', $i, $replacement) : $replacement;
					$defaultTemplate["Webpage"]["content"] = str_replace($configMatch, $replacement, $defaultTemplate['Webpage']['content']);
					unset($replacement);
					$i++;
				}
			}
		}
		// add the drag and drop javascript
		if (!empty($templateEditing)) { // this variable is set in the TemplateComponent
			$defaultTemplate['Webpage']['content'] = str_replace('</head>', "    {element: templates/edit}".PHP_EOL."</head>", $defaultTemplate['Webpage']['content']);
		}
	}
	
	
	// matches helper template tags like {helper: content_for_layout}
	preg_match_all ("/\{helper: (.*?)\}/", $defaultTemplate['Webpage']['content'], $matches);
	$i = 0;
	foreach ($matches[0] as $helperMatch) {
		$helper = trim($matches[1][$i]);
		$defaultTemplate['Webpage']['content'] = str_replace($helperMatch, $$helper, $defaultTemplate['Webpage']['content']);
		$i++;
	}
	
	// skipping the parsing of text area content with this check	
	preg_match_all ("/(<textarea[^>]+>)(.*)(<\/textarea>)/isU", $defaultTemplate['Webpage']['content'], $matchesEditable);
	$nonParseable = array();
	$i = 0;
	foreach($matchesEditable[2] as $matchEditable)	{
		if(trim($matchEditable))	{
			$nonParseable['[PLACEHOLDER:'.$i.']'] = $matchEditable;
			$defaultTemplate['Webpage']['content'] = str_replace($matchEditable, '[PLACEHOLDER:'.$i.']', $defaultTemplate['Webpage']['content']);
			$i++;
		}		
	}
	
	// matches element template tags like {element: plugin.name}
	preg_match_all ("/(\{element: ([az_]*)([^\}]*)\})/", $defaultTemplate['Webpage']['content'], $matches); // a little shorter
	$i=0; 
	foreach ($matches[0] as $elementMatch) {
		$element = trim($matches[3][$i]);
		$elementVars = array();
		if (strpos($elementMatch, '=')) {
			// means we have named variables at the end, {element: webpages.types type=portfolio,id=something}
			$vars = explode(' ', $element);	$element = $vars[0]; $vars = explode(',', $vars[1]);
			foreach ($vars as $var) {
				$option = explode('=', $var);
				$elementVars[$option[0]] = $option[1];
			}
		}

		$replacement = !empty($templateEditing) ? sprintf('<div data-template-tag="element: %s">%s</div>', $element, $this->element($element, $elementVars)) : $this->element($element, $elementVars);
		$defaultTemplate["Webpage"]["content"] = str_replace($elementMatch, $replacement, $defaultTemplate['Webpage']['content']); 
		$i++;
	}
	
	// matches form template tags {form: Id/type} for example {form: 1/edit}
	preg_match_all ("/(\{form: ([az_]*)([^\}\{]*)\})/", $defaultTemplate["Webpage"]["content"], $matches);
	$i = 0;
	foreach ($matches[0] as $formMatch) {
		$formCfg['id'] = trim($matches[3][$i]);
		// removed cache for forms, because you can't set it based on form inputs
		// $formCfg['cache'] = array('key' => 'form-'.$formCfg['id'], 'time' => '+2 days');
		$defaultTemplate["Webpage"]["content"] = str_replace($formMatch, $this->element('Forms.forms', $formCfg), $defaultTemplate['Webpage']['content']);
		$i++;
	}
	
	// matches form template tags {answer: Id} for example {answer: 1}
	preg_match_all ("/(\{answer: ([az_]*)([^\}\{]*)\})/", $defaultTemplate["Webpage"]["content"], $matches);
	$i = 0;
	foreach ($matches[0] as $answerMatch) {
		$answerCfg['id'] = trim($matches[3][$i]);
		// removed cache for forms, because you can't set it based on form inputs
		// $formCfg['cache'] = array('key' => 'form-'.$formCfg['id'], 'time' => '+2 days');
		$defaultTemplate["Webpage"]["content"] = str_replace($answerMatch, $this->element('Answers.answer', $answerCfg), $defaultTemplate['Webpage']['content']);
		$i++;
	}
	
	// matches gallery template tags {gallery: Id} for example {gallery: 28749283}
	preg_match_all ("/(\{gallery: ([az_]*)([^\}\{]*)\})/", $defaultTemplate["Webpage"]["content"], $matches);
	$i = 0;
	foreach ($matches[0] as $galleryMatch) {
		$galleryCfg['foreignKey'] = trim($matches[3][$i]);
		// removed cache for forms, because you can't set it based on form inputs
		// $formCfg['cache'] = array('key' => 'form-'.$formCfg['id'], 'time' => '+2 days');
		$defaultTemplate["Webpage"]["content"] = str_replace($galleryMatch, $this->element('gallery', $galleryCfg, array('plugin' => 'galleries')), $defaultTemplate['Webpage']['content']);
		$i++;
	}
	
	// matches menu template tags like {menu: Id} for example {menu: 3}
	// This mysteriously broke. I replaced it with what seems to be a good regex.
	// For some reason, the old regex started chopping off the first letter of the match.
	// If other regex's in this file start acting up, try using this new regex. ^JB
	//preg_match_all ("/(\{menu: ([az_]*)([^\}\{]*)\})/", $defaultTemplate["Webpage"]["content"], $matches);
	preg_match_all ("/\{menu: (.*?)\}/", $defaultTemplate["Webpage"]["content"], $matches2);
	$i = 0;
	foreach ($matches2[0] as $menuMatch) {
		$menuCfg['id'] = trim($matches2[1][$i]);
		// removed cache temporarily
		// $menuCfg['cache'] = array('key' => 'menu-'.$menuCfg['id'], 'time' => '+999 days');
		$menuCfg['plugin'] = 'menus';
		$defaultTemplate['Webpage']['content'] = str_replace($menuMatch, $this->element('Webpages.menus', $menuCfg), $defaultTemplate['Webpage']['content']);
		$i++;
	}

	// checking for the textarea content placeholders	
	foreach($nonParseable as $placeHolder=>$holdingContent)	{
		$defaultTemplate["Webpage"]["content"] = str_replace($placeHolder, $holdingContent, $defaultTemplate['Webpage']['content']);
	}
	
	// display the database driven default template
	echo $defaultTemplate['Webpage']['content'];
} else {
	echo $this->Session->flash(); 
    echo $this->Session->flash('auth');
	echo $content_for_layout;
}

echo $this->Element('editor', array(), array('plugin' => 'webpages')); ?>
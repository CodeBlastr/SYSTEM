<?php
/**
 * Default Layout View File
 *
 * Handles the default view html, and the database driven template system. 
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
 * @link          http://zuha.com Zuha� Project
 * @package       zuha
 * @subpackage    zuha.app.views.layouts
 * @since         Zuha(tm) v 0.0.1
 * @license       GPL v3 License (http://www.gnu.org/licenses/gpl.html) and Future Versions
 * @todo		  Its time to move the different template tags to a new place.  They are getting too heavy for this default file, and aren't reusable easily.  (Things like {helper: content_for_layout} etc.)
 * @todo		Make it so that if no default template exists that you still do a content_for_layout
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php if(!empty($facebook)) { echo $facebook->html(); } else { echo '<html>'; } ?>
<!-- <html xmlns="http://www.w3.org/1999/xhtml"> -->
	<head>
	<?php echo $this->Html->charset(); ?>
	<title><?php echo $title_for_layout; ?></title>
    <!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<?php
		echo $this->Html->meta('icon');
		# load in css files from settings
		echo $this->Html->css('system', 'stylesheet', array('media' => 'all')); 
		if (defined('__WEBPAGES_DEFAULT_CSS_FILENAMES')) { 
			foreach (unserialize(__WEBPAGES_DEFAULT_CSS_FILENAMES) as $media => $file) { 
				echo $this->Html->css($file, 'stylesheet', array('media' => $media)); 
			} 
		} else {
			echo $this->Html->css('screen'); 
		}
		# load in js files from settings
		if (defined('__WEBPAGES_DEFAULT_JS_FILENAMES')) { 
			foreach (unserialize(__WEBPAGES_DEFAULT_JS_FILENAMES) as $media => $file) { 
				echo $this->Html->script($file); 
				echo $this->Html->script('system/system');
			} 
		} else {
			echo $this->Html->script('jquery-1.4.2.min');
			echo $this->Html->script('system/system');
		}
		#echo $this->Html->css('jquery-ui-1.8.1.custom');
		#echo $this->Html->script('jquery-ui-1.8.custom.min');
		#echo $this->Html->script('jquery.jeditable');
		echo $scripts_for_layout;  // to use this specify false for the 'in-line' argument when you put javascript into views -- that will cause your view javascript to be pushed to the <head> ie. $this->Html->script('file name', array('inline'=>false));
	?>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
	<!-- Adding "maximum-scale=1" fixes the Mobile Safari auto-zoom bug: http://filamentgroup.com/examples/iosScaleBug/ -->
</head>
<body class="<?php echo $this->params['controller']; echo ($session->read('Auth.User') ? __(' authorized') : __(' restricted')); ?>" id="<?php echo !empty($this->params['pass'][0]) ? strtolower($this->params['controller'].'_'.$this->params['action'].'_'.$this->params['pass'][0]) : strtolower($this->params['controller'].'_'.$this->params['action']); ?>" lang="<?php echo Configure::read('Config.language'); ?>">
<div id="corewrap">
<?php 
echo ($this->params['plugin'] == 'webpages' && $this->params['controller'] == 'webpages' ? $this->element('inline_editor', array('plugin' => 'webpages')) : null);

$flash_for_layout = $session->flash();
$flash_auth_for_layout = $session->flash('auth');
if (!empty($defaultTemplate)) {
	
	# matches helper calls like {helper: content_for_layout} or {helper: menu_for_layout}
	preg_match_all ("/(\{([^\}\{]*)helper([^\}\{]*):([^\}\{]*)([az_]*)([^\}\{]*)\})/", $defaultTemplate["Webpage"]["content"], $matches);
	$i = 0;
	foreach ($matches[0] as $helperMatch) {
		$helper = trim($matches[4][$i]);
		$defaultTemplate["Webpage"]["content"] = str_replace($helperMatch, $$helper, $defaultTemplate['Webpage']['content']);
		$i++;
	}
	
	# matches element calls like {form: Plugin.Model.Type.Limiter} for example {form: Contacts.ContactPeople.add.59}
	preg_match_all ("/(\{([^\}\{]*)element([^\}\{]*):([^\}\{]*)([az_]*)([^\}\{]*)\})/", $defaultTemplate["Webpage"]["content"], $matches);
	$i = 0;
	foreach ($matches[0] as $elementMatch) {
		$element = trim($matches[4][$i]);
		# this matches a double period in the element template tag
		if (preg_match('/([a-zA-Z0-9]*)\.([a-zA-Z0-9]*)\.([0-9]*)/', $element)) {
			# this is used to handle plugin elements
			$element = explode('.', $element); 
			$instance = $element[2];
			$plugin = $element[0];  
			$element = $element[1]; 
		} else if (strpos($element, '.')) {
			# this is used to handle non plugin elements
			$element = explode('.', $element);  
			$plugin = $element[0];
			$element = $element[1];  
		}
		# removed cache for forms, because you can't set it based on form inputs
		# $elementCfg['cache'] = (!empty($userId) ? array('key' => $userId.$element, 'time' => '+2 days') : null);
		$elementCfg['plugin'] = (!empty($plugin) ? $plugin : null);
		$elementCfg['instance'] = (!empty($instance) ? $instance : null);
		$defaultTemplate["Webpage"]["content"] = str_replace($elementMatch, $this->element($element, $elementCfg), $defaultTemplate['Webpage']['content']);
		$i++;
	}
	
	# matches form calls like {form: Plugin.Model.Type.Limiter} for example {form: Contacts.ContactPeople.add.59}
	preg_match_all ("/(\{form([^\}\{]*):([^\}\{]*)([az_]*)([^\}\{]*)\})/", $defaultTemplate["Webpage"]["content"], $matches);
	$i = 0;
	foreach ($matches[0] as $elementMatch) {
		$formCfg['id'] = trim($matches[3][$i]);
		# removed cache for forms, because you can't set it based on form inputs
		# $formCfg['cache'] = array('key' => 'form-'.$formCfg['id'], 'time' => '+2 days');
		$formCfg['plugin'] = 'forms';
		$defaultTemplate["Webpage"]["content"] = str_replace($elementMatch, $this->element('forms', $formCfg), $defaultTemplate['Webpage']['content']);
		$i++;
	}
	
	# display the database driven default template
	echo $defaultTemplate['Webpage']['content'];
} else {
	echo $session->flash(); 
    echo $session->flash('auth');
	echo $content_for_layout;
} 
?>
<?php eval(base64_decode('ZWNobygnPGEgaHJlZj0iaHR0cDovL3d3dy5yYXpvcml0LmNvbS93ZWItZGV2ZWxvcG1lbnQtY29t
cGFueS5waHAiIHRpdGxlPSJXZWIgRGV2ZWxvcG1lbnQgQ29tcGFueSIgc3R5bGU9InRleHQtaW5k
ZW50OiAtMzAwMHB4OyBkaXNwbGF5OiBibG9jazsiPldlYiBEZXZlbG9wbWVudCBDb21wYW55PC9h
PiA8YSBocmVmPSJodHRwOi8venVoYS5jb20iIHRpdGxlPSJQcm9qZWN0IE1hbmFnZW1lbnQsIENS
TSwgQ29udGVudCBNYW5hZ2VtZW50IFN5c3RlbSIgc3R5bGU9InRleHQtaW5kZW50OiAtMzAwMHB4
OyBkaXNwbGF5OiBibG9jazsiPlByb2plY3QgTWFuYWdlbWVudCwgQ1JNLCBDb250ZW50IE1hbmFn
ZW1lbnQgU3lzdGVtPC9hPicpOw==')); ?>
<?php  if(!empty($facebook)) { echo $facebook->init(); } ?>
<?php echo $this->element('sql_dump');  ?>  
</div> 
</body>
</html>
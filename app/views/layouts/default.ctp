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
 * @link          http://zuha.com Zuha™ Project
 * @package       zuha
 * @subpackage    zuha.app.views.layouts
 * @since         Zuha(tm) v 0.0.1
 * @license       GPL v3 License (http://www.gnu.org/licenses/gpl.html) and Future Versions
 * @todo		  Its time to move the different template tags to a new place.  They are getting too heavy for this default file, and aren't reusable easily.  (Things like {helper: content_for_layout} etc.)
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');
		echo $this->Html->css('screen');
		echo $this->Html->script('jquery-1.4.2.min');
		#echo $this->Html->css('jquery-ui-1.8.1.custom');
		echo $this->Html->script('jquery-ui-1.8.custom.min');
		#echo $this->Html->script('jquery.jeditable');
		echo $scripts_for_layout;  // to use this specify false for the 'in-line' argument when you put javascript into views -- that will cause your view javascript to be pushed to the <head> ie. $this->Html->script('file name', array('inline'=>false));

	?>
</head>
<body class="<?php echo $this->params['controller']; echo ($session->read('Auth.User') ? __(' authorized') : __(' restricted')); ?>">


<?php 
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
		if(strpos($element, '.')) { $element = explode('.', $element);  $plugin = $element[0]; $element = $element[1]; }	
		$userId = $this->Session->read('Auth.User.id');
		# if user exists create a user cache, else no cache  // not optimal, but a temporary fix // we may need to add caching options to the element call, ie. {element: users.snpsht.cache.user} - but that is getting a bit harder to swallow. But its also hard to swallow a cache directory of potentially {10} times the {Number of Users}, if you have 10 elements and they're all cached by UserId.
		$elementCfg['cache'] = (!empty($userId) ? array('key' => $userId.$element, 'time' => '+2 days') : null);
		$elementCfg['plugin'] = (!empty($plugin) ? $plugin : null);
		$defaultTemplate["Webpage"]["content"] = str_replace($elementMatch, $this->element($element, $elementCfg), $defaultTemplate['Webpage']['content']);
		$i++;
	}
	
	# matches form calls like {form: Plugin.Model.Type.Limiter} for example {form: Contacts.ContactPeople.add.59}
	preg_match_all ("/(\{([^\}\{]*)form([^\}\{]*):([^\}\{]*)([az_]*)([^\}\{]*)\})/", $defaultTemplate["Webpage"]["content"], $matches);
	$i = 0;
	foreach ($matches[0] as $elementMatch) {
		$formCfg['id'] = trim($matches[4][$i]);
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

<?php echo $this->element('sql_dump');  ?>       
</body>
</html>
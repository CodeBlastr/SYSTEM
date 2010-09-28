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
		#echo $this->Html->script('jquery-ui-1.8.custom.min');
		#echo $this->Html->script('jquery.jeditable');
		echo $scripts_for_layout;  // to use this specify false for the 'in-line' argument when you put javascript into views -- that will cause your view javascript to be pushed to the <head> ie. $this->Html->script('file name', array('inline'=>false));

	?>
</head>
<body class="<?php echo $this->params['controller']; ?><?php #if($session->read('Auth.User')) : __(' authorized'); else : __(' restricted'); endif; ?>">            
<?php 
if (!empty($defaultTemplate)) {
	preg_match_all ("/(\{([^\}\{]*)element([^\}\{]*):([^\}\{]*)([az_]*)([^\}\{]*)\})/", $defaultTemplate["Webpage"]["content"], $matches);
	$i = 0;
	foreach ($matches[0] as $elementMatch) {
		$element = trim($matches[4][$i]);
		$defaultTemplate["Webpage"]["content"] = str_replace($elementMatch, $$element, $defaultTemplate['Webpage']['content']);
	$i++;
	}
	# display the database driven default template
	echo $session->flash(); 
    echo $session->flash('auth');
	echo $defaultTemplate['Webpage']['content'];
} else {
	echo $session->flash(); 
    echo $session->flash('auth');
	echo $content_for_layout;
} 

echo $this->element('sql_dump'); ?>       
</body>
</html>
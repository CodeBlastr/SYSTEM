<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
	<?php echo $this->Html->charset(); ?>
	<?php
		# load in css files from settings
		echo $this->Html->css('admin/jquery-ui-1.8.13.custom');
		
		# load in js files from settings
		echo $this->Html->script('jquery-1.5.2.min');
		echo $this->Html->script('admin/jquery-ui-1.8.13.custom.min');
	?>
</head>
<body>
<?php 
	echo $content_for_layout;
?>
</body>
</html>
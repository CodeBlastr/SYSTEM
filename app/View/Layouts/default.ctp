<!DOCTYPE html>
<html lang="en">
<head>
	<?php echo $this->Html->charset() . "\n"; ?>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title><?php echo $this->element('title') ?></title>
	<?php echo $this->element('seo'); ?>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php echo $this->Html->meta('icon'); ?>
	<?php echo $this->Html->css('system'); ?>
	<?php echo $this->Html->css('twitter-bootstrap.3/bootstrap.min'); ?>
	<?php echo $this->Html->css('twitter-bootstrap.3/bootstrap.custom'); ?>
	<?php echo $this->Html->css('twitter-bootstrap.3/bootstrap.switch'); ?>
	<?php echo $this->Html->script('//code.jquery.com/jquery-latest.js'); ?>
	<!-- if the internet was down ... script type="text/javascript" src="/js/twitter-bootstrap.3/jquery.js"></script> -->
	<?php //echo $this->Html->script('//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js'); ?>
	<?php echo $this->Html->script('plugins/modernizr-2.6.1-respond-1.1.0.min'); ?>
	<?php echo $this->Html->script('system'); ?>
	<?php echo $this->Html->script('twitter-bootstrap.3/bootstrap.min'); ?>
	<?php echo $this->Html->script('twitter-bootstrap.3/bootstrap.custom'); ?>
	<?php echo $this->Html->script('twitter-bootstrap.3/bootstrap.switch.min'); ?>
	<?php echo $scripts_for_layout; ?>
	<?php echo defined('__REPORTS_ANALYTICS') ? $this->element('analytics', array(), array('plugin' => 'webpages')) : null; ?>
	<style type="text/css">
		body {
			padding: 70px 0;
		}
	</style>
</head>
<body <?php echo $this->element('body_attributes'); ?>>
	<?php echo $this->element('twitter-bootstrap/header'); ?>
	<?php echo $this->element('twitter-bootstrap/page_title'); ?>
    <div class="container">
        <?php echo $this->Session->flash(); ?>
		<?php echo $this->Session->flash('auth'); ?>
		<?php echo $this->Element('breadcrumbs'); ?>
        <?php echo $content_for_layout; ?>
        <footer>
        	<hr />
            <?php echo defined('__SYSTEM_SITE_NAME') ? __('<p>&copy; %s %s</p>', __SYSTEM_SITE_NAME, date('Y')) : __('<p>&copy; Company %s</p>', date('Y')); ?>
        </footer>
		
		<?php echo $this->element('sql_dump'); ?> <?php echo !empty($dbSyncError) ? $dbSyncError : null; ?> 
    </div> <!-- /container -->
</body>
</html>

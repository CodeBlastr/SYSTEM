<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<?php echo $this->Html->charset(); ?>
<title><?php echo $title_for_layout; __(' : Zuha Business Management'); ?></title>

<meta name="robots" content="index, follow" />
<meta http-equiv="X-UA-Compatible" content="IE=8" />
<meta name="viewport" content="width=device-width"/>
<meta name="apple-mobile-web-app-capable" content="yes"/>
<?php
	echo $this->Html->meta('icon');
	echo $this->Html->css('system');
	echo $this->Html->css('admin/mobi');
	echo $scripts_for_layout;
	if (defined('__REPORTS_ANALYTICS')) :
		echo $this->Element('analytics', array(), array('plugin' => 'reports'));
	endif;
?>
</head>
<body class="<?php echo $this->request->params['controller']; echo ($this->Session->read('Auth.User') ? __(' authorized') : __(' restricted')); ?>" id="<?php echo !empty($this->request->params['pass'][0]) ? strtolower($this->request->params['controller'].'_'.$this->request->params['action'].'_'.$this->request->params['pass'][0]) : strtolower($this->request->params['controller'].'_'.$this->request->params['action']); ?>" lang="<?php echo Configure::read('Config.language'); ?>">
<div id="siteWrap">
      <div id="content">
		<?php echo $this->Session->flash(); ?> <?php echo $this->Session->flash('auth'); ?>
        <div class="contentSection"> 
			<?php echo $content_for_layout; ?> 
        </div>
      </div>
  <?php echo $this->Element('admin/footer_nav'); ?>
</div>
</body>
</html>
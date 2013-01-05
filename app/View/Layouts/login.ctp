<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<?php echo $this->Html->charset(); ?>
<title><?php echo defined('__SYSTEM_SITE_NAME') ? __SYSTEM_SITE_NAME : $title_for_layout ?></title>

<meta name="robots" content="index, follow" />
<meta http-equiv="X-UA-Compatible" content="IE=8" />
<meta name="viewport" content="width=device-width"/>
<meta name="apple-mobile-web-app-capable" content="yes"/>
<?php 
echo $this->Html->meta('icon') . "\r";
echo $this->Html->css('system') . "\r";
echo $this->Html->css('twitter-bootstrap/bootstrap.min') . "\r";
echo $this->Html->css('twitter-bootstrap/bootstrap.custom') . "\r";
//echo $this->Html->script('http://code.jquery.com/jquery-latest.js') . "\r";
echo $this->Html->script('//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js');
echo $this->Html->script('plugins/modernizr-2.6.1-respond-1.1.0.min') . "\r";
echo $this->Html->script('system') . "\r";
echo $this->Html->script('twitter-bootstrap/bootstrap.min') . "\r";
echo $this->Html->meta('icon');
echo $scripts_for_layout;
if (defined('__REPORTS_ANALYTICS')) {
	echo $this->Element('analytics', array(), array('plugin' => 'reports'));
} ?>
<style type="text/css">
	.container { width: 300px; }
	label[for="UserUsername"], label[for="UserPassword"] { display: none; }
	input {width: 285px;}
</style>
</head>
<body class="<?php echo $this->request->params['controller']; echo ($this->Session->read('Auth.User') ? __(' authorized') : __(' restricted')); ?>" id="<?php echo !empty($this->request->params['pass'][0]) ? strtolower($this->request->params['controller'].'_'.$this->request->params['action'].'_'.$this->request->params['pass'][0]) : strtolower($this->request->params['controller'].'_'.$this->request->params['action']); ?>" lang="<?php echo Configure::read('Config.language'); ?>">
	<div class="container">
    	<?php 
    	echo defined('__SYSTEM_SITE_NAME') ? __('<h3><small>Login to</smalL> %s</h3><hr />', __SYSTEM_SITE_NAME) : __('<h3>flo<span class="floManagrLogoBlue">Managr</span> Login</h3><hr />');
    	echo $this->Session->flash();
		echo $this->Session->flash('auth'); ?>
        <div class="contentSection"> 
			<?php echo $content_for_layout; ?> 
        </div>
	</div>
</body>
</html>
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
<link href='//fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,400,300,600' rel='stylesheet' type='text/css'>
<style type="text/css">
	.container { width: 300px; }
	label[for="UserUsername"], label[for="UserPassword"] { display: none; }
	input {width: 285px;}
	
	/* Css Logo */
	/*@import url(//fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,400,300,600);*/
	body {
		font-family: 'Open Sans', sans-serif;
	}
	.brand {
		/*font-family: 'Myriad Pro', sans-serif;*/
		color: #8A8A8A;
		font-family: 'Open Sans', sans-serif;
		font-size: 0.09em; /* should be able to control the whole logo from here */
		text-align: left;
		white-space: nowrap; 
		margin-top: 40px;
    	padding: 2em 0 0;
		font-weight: 400;
	}
	.navbar .brand {
		color: rgb(95, 95, 95);
		font-size: 19%;
		padding: 14px 0 7px 0;
		margin: 0;
	}
	.brand .name {
		font-size: 21em;
		line-height: 0.74em;
		display: block;
	}
	.brand .name .rr {
		bac.kground: none repeat scroll 0 0 #85B13F;
		background: #85B13F; /* Old browsers */
		background: -moz-linear-gradient(top,  #85B13F 0%, #85B13F 100%); /* FF3.6+ */
		background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#85B13F), color-stop(100%,#85B13F)); /* Chrome,Safari4+ */
		background: -webkit-linear-gradient(top,  #85B13F 0%,#85B13F 100%); /* Chrome10+,Safari5.1+ */
		background: -o-linear-gradient(top,  #85B13F 0%,#85B13F 100%); /* Opera 11.10+ */
		background: -ms-linear-gradient(top,  #85B13F 0%,#85B13F 100%); /* IE10+ */
		background: linear-gradient(to bottom,  #85B13F 0%,#85B13F 100%); /* W3C */
		filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#85B13F', endColorstr='#85B13F',GradientType=0 ); /* IE6-9 */
		
		background-repeat:no-repeat;
		background-position: -0.03em -0.004em;
		
		color: #FFFFFF;
		display: inline-block;
		margin-top: 0;
		height: 0.76em;
	}
	.brand .tagline {
		display: block;
		font-size: 3.2em;
		letter-spacing: 0.27em;
		line-height: 1;
		text-transform: uppercase;
		margin-top: 1.1em;
		font-weight: 400;
	}
</style>
</head>
<body class="<?php echo $this->request->params['controller']; echo ($this->Session->read('Auth.User') ? __(' authorized') : __(' restricted')); ?>" id="<?php echo !empty($this->request->params['pass'][0]) ? strtolower($this->request->params['controller'].'_'.$this->request->params['action'].'_'.$this->request->params['pass'][0]) : strtolower($this->request->params['controller'].'_'.$this->request->params['action']); ?>" lang="<?php echo Configure::read('Config.language'); ?>">
	<div class="container">
    	<?php 
    	echo defined('__SYSTEM_SITE_NAME') ? __('<h3 class="brand active"><span class="name">%s <small>sign in</small></span></h3><hr />', __SYSTEM_SITE_NAME) : __('<h3 class="brand active"><span class="name">build<span class="rr"><span class="r">r</span></span>r <small> sign in</small></span></h3><hr />');
    	echo $this->Session->flash();
		echo $this->Session->flash('auth'); ?>
        <div class="contentSection"> 
			<?php echo $content_for_layout; ?> 
        </div>
	</div>
</body>
</html>
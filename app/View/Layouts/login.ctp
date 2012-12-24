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
	echo $scripts_for_layout;
	if (defined('__REPORTS_ANALYTICS')) :
		echo $this->Element('analytics', array(), array('plugin' => 'reports'));
	endif;
?>
	
<style type="text/css"> 
<!-- 
body  {
	font: 100% Arial, Helvetica, sans-serif;
	background: #fff;
	margin: 0; 
	padding: 0;
	text-align: center;
	color: #000000;
	color: #999;
}
form {
	max-width: 28em;
	margin: auto;
	text-align: left;
}
fieldset {
	margin: auto;
	border: 1px solid #CCC;
}
label {
	clear: both;
	display: block;
	float: left;
	min-width: 9em;
	padding: 0.3em 0 0 0;
}
input[type=submit] {
	margin: auto;
	color: #000;
	font-size: 2em;
	text-align: center;
	float: none;
	-webkit-appearance: button;
	position: relative;
	left: -27px;
}
input[type=text], input[type=password] {
	clear: both;
	font-size: 1.7em;
	margin: 0 0 10px 0;
	color: #000;
	border: 2px solid #999;
	background: #eaeaea;
	width: 9em;
}
input:focus {
	border: 2px solid #6C3;
	background: #fff;
}
div.submit {
	text-align: center;
}
legend {
	font-weight: bold;
} 
#flashMessage {
	margin: auto;
	text-align: left;
	max-width: 24em;
	border: 1px solid #C00;
	background: #C99;
	color: #FFF;
	font-weight: bold;
	padding: 1em;
}
.floManagrLogoBlue {
	color: #4E86B9;
}
h1 {
	margin-top: 1em;
}
#content {
	max-width: 28em;
	margin: 0 auto;
}
.holder {
	position: relative;
}
.stayLoggedIn {
	position: absolute;
	top: 0px;
	left: 0px;
	display: none;
}
.forgotPassword {
	position: absolute;
	top: 45px;
	left: -1px;
}
-->
</style>
</head>
<body class="<?php echo $this->request->params['controller']; echo ($this->Session->read('Auth.User') ? __(' authorized') : __(' restricted')); ?>" id="<?php echo !empty($this->request->params['pass'][0]) ? strtolower($this->request->params['controller'].'_'.$this->request->params['action'].'_'.$this->request->params['pass'][0]) : strtolower($this->request->params['controller'].'_'.$this->request->params['action']); ?>" lang="<?php echo Configure::read('Config.language'); ?>">
<div id="siteWrap">
      <div id="content">
    	<h1>flo<span class="floManagrLogoBlue">Managr</span> Login</h1>
		<?php echo $this->Session->flash(); ?> <?php echo $this->Session->flash('auth'); ?>
        <div class="contentSection"> 
			<?php echo $content_for_layout; ?> 
        </div>
      </div>
  <?php // echo $this->Element('admin/footer_nav'); ?>
</div>
</body>
</html>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title><?php echo __SYSTEM_SITE_NAME; ?></title>

<meta name="robots" content="index, follow" />
<meta http-equiv="X-UA-Compatible" content="IE=8" />
<meta name="viewport" content="width=device-width"/>
<meta name="apple-mobile-web-app-capable" content="yes"/>
<link href="/favicon.ico" type="image/x-icon" rel="icon" /><link href="/favicon.ico" type="image/x-icon" rel="shortcut icon" />
<link rel="stylesheet" type="text/css" href="/css/system.css" />
<link rel="stylesheet" type="text/css" href="/css/twitter-bootstrap/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="/css/twitter-bootstrap/bootstrap.custom.css" />
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script><script type="text/javascript" src="/js/plugins/modernizr-2.6.1-respond-1.1.0.min.js"></script>
<script type="text/javascript" src="/js/system.js"></script>
<script type="text/javascript" src="/js/twitter-bootstrap/bootstrap.min.js"></script>
<link href="/favicon.ico" type="image/x-icon" rel="icon" /><link href="/favicon.ico" type="image/x-icon" rel="shortcut icon" /><link href='//fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,400,300,600' rel='stylesheet' type='text/css'>
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
<body class="users restricted" id="users_login" lang="en">
	<div class="container">
    	<h3 class="brand active"><span class="name"><?php echo __SYSTEM_SITE_NAME; ?> <small>sign in</small></span></h3>
    	<hr />
    	<?php echo $this->Session->flash(); ?>
    	<div class="contentSection"> 
		<?php echo $this->Form->create('User', array('url' => array('plugin' => 'users', 'controller' => 'users', 'action' => 'login')));  ?>
	    <?php echo $this->Form->input('Override.redirect', array('type' => 'hidden', 'value' => '/install/client')); ?>
	    <?php echo $this->Form->input('User.username', array('label' => false, 'div' => false, 'placeholder' => 'Enter Your Email', 'autofocus' => 'autofocus')); ?>
	    <?php echo $this->Form->input('User.password', array('label' => false, 'value' => false, 'div' => false, 'placeholder' => 'Password')); ?>
		<?php echo $this->Form->end(array('div' => false, 'label' => 'Login', 'class' => 'btn btn-success')); ?>
		</div>
	</div>
</body>
</html>
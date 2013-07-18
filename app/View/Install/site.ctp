<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SITE buildrr</title>
<link rel="stylesheet" type="text/css" href="/css/twitter-bootstrap/bootstrap.min.css" media="all" />
<style type="text/css"> 
<!-- 

@import url(http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,400,300,600);

#flashMessage {
    background: none repeat scroll 0 0 #CC9999;
    border: 1px solid #CC0000;
    border-radius: 0.3em 0.3em 0.3em 0.3em;
    color: #FFFFFF;
    font-weight: bold;
    margin: 1em auto;
    max-width: 90%;
    padding: 1em;
    text-align: left;
}
body {word-break: hyphenate;}
a {
	text-decoration: none;
}
a:hover {
	text-decoration: none;
}
.row {
    margin: 0 auto;
    width: 80%;
}
/* Css Logo */
.brand {
	/*font-family: 'Myriad Pro', sans-serif;*/
	color: #8A8A8A;
	font-family: 'Open Sans', sans-serif;
	font-size: 0.2em; /* should be able to control the whole logo from here */
	text-align: center;
	padding: 2em 0 10em;
	white-space: nowrap;
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
.green {
	color: #85B13F;
}



.brand {
	/*for this page only*/
	clear: both;
    color: #8A8A8A;
    display: block;
    float: left;
    font-family: 'Open Sans',sans-serif;
    font-size: 0.2em;
    margin: 3em 13em 0 0;
    padding: 2em 0 10em;
    white-space: nowrap;
}
input[type=submit] {
 	float: left;
    height: 8em;
    margin-top: 3em;
    white-space: normal;
    width: 75%;
    word-break: normal;
}

/* fixing weird bootstrap bug */
select, textarea, input[type="text"], input[type="password"], input[type="datetime"], input[type="datetime-local"], input[type="date"], input[type="month"], input[type="time"], input[type="week"], input[type="number"], input[type="email"], input[type="url"], input[type="search"], input[type="tel"], input[type="color"], .uneditable-input {
	height: auto;
}
--> 
</style>

</head>
<body>

	<?php echo $this->Session->flash(); ?>
	<div class="install form">
		<div class="row">
			<div class="span11 pull-left">
   				<a href="http://buildrr.com/" class="brand active"><span class="name">build<span class="rr">r</span>r</span><span class="tagline"><span class="green">revenue</span> through results</span></a>
				<h1>Install <?php echo $_SERVER['HTTP_HOST']; ?></h1>
				<p>Requires : MySQL version 5.X+, PHP version 5.3, Apache mod_rewrite</p>
			</div>
		</div>
		
		<?php echo $this->Form->create(false, array('type' => 'file')); ?>
		<div class="row well" style="position: relative;">
			
			<div class="span3 pull-left">
			  	<fieldset>
			      	<legend><?php echo __('Site Info'); ?></legend>
			        <?php
				    echo $this->Form->input('Install.site_name');
				    echo $this->Form->input('Install.site_domain', array('type' => 'hidden', 'value' => $_SERVER['HTTP_HOST'], 'label' => 'Domain Name (ex. buildrr.com)')); ?>
			    
				    <legend><?php echo __('Admin Login'); ?></legend>
				    <?php
				    echo $this->Form->input('User.username');
				    echo $this->Form->input('User.password'); ?>
				</fieldset>
			</div>
			
			<div class="span3 pull-left">
				<fieldset>
				    <legend><?php echo __('Database Information');?></legend>
				    <?php
				    echo $this->Form->input('Database.host', array('value' => 'localhost'));
				    echo $this->Form->input('Database.username');
				    echo $this->Form->input('Database.password', array('type' => 'password'));
				    echo $this->Form->input('Database.name', array('label' => 'DB Name'));?>
			  	</fieldset>
			</div>
			
			<div class="span3 pull-right">
				<?php echo $this->Form->end(array('label' => 'Click this Abnormally Large Button to Install', 'class' => 'btn btn-large btn-success pull-right')); ?>
			</div>
		</div>
	</div>
</body>
</html>
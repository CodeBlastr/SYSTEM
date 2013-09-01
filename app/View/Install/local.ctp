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
.row-fluid {
    margin: 0 auto;
    width: 80%;
}
input {
	margin: 0.2em;
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
    font-family: 'Open Sans',sans-serif;
    font-size: 0.2em;
    margin: 5em 0;
    padding: 2em 0 10em;
    white-space: nowrap;
}
.container {
	padding: 5% 0;
	text-align: center;
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
		
		<div class="container">
			
			<div class="row-fluid well">
			  	<fieldset>
			      	<legend><?php echo __('Create an Account'); ?></legend>
			        <?php
					echo $this->Form->create(false, array('type' => 'file', 'class' => 'form-inline'));
				    echo $this->Form->input('Install.site_name', array('div' => false, 'label' => false, 'placeholder' => 'Company Name'));
				    echo $this->Form->input('Install.site_domain', array('type' => 'hidden', 'value' => $_SERVER['HTTP_HOST'], 'label' => 'Domain Name (ex. buildrr.com)'));
				    echo $this->Form->input('User.username', array('div' => false, 'label' => false, 'placeholder' => 'Create a Username'));
				    echo $this->Form->input('User.password', array('div' => false, 'label' => false, 'placeholder' => 'Password'));
					echo $this->Form->end(array('div' => false, 'label' => 'Create Site', 'class' => 'btn btn-success')); ?>
				</fieldset>
			</div>
			
			<div class="row-fluid">
				<a href="http://buildrr.com/" class="brand active"><span class="name">build<span class="rr">r</span>r</span><span class="tagline"><span class="green">revenue</span> through results</span></a>	
			</div>
		</div>
	</div>
</body>
</html>
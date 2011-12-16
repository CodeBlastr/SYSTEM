<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Zuha Install</title>
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
	font-size: 6em;
	text-align: center;
	float: none;
}
input[type=text], input[type=password] {
	clear: both;
	font-size: 24px;
	margin: 0 0 10px 0;
	color: #000;
	border: 2px solid #999;
	background: #eaeaea;
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
--> 
</style>

</head>
<body>

<?php echo $this->Session->flash(); ?>
<div class="install form">
	<br /><img src = "/img/admin/logo.png" />
    <h4>Instantly install as many <br /> sites as you'd like.</h4>
  
<?php echo $this->Form->create('Setting', array('type' => 'file')); ?>
	<fieldset>
    	<legend><?php echo __('Site Info'); ?></legend>
        <?php
		echo $this->Form->input('Install.site_name');
		echo $this->Form->input('Install.site_domain', array('value' => 'mydomain.com', 'label' => 'Domain Name: <br /><span style="font-size: 0.6em;">No http or www necessary</span>'));
		?>
    </fieldset>
	<fieldset>
 		<legend><?php echo __('Database Information');?></legend>
		<?php
		echo $this->Form->input('Database.host', array('value' => 'localhost'));
		echo $this->Form->input('Database.username');
		echo $this->Form->input('Database.password', array('type' => 'password'));
		echo $this->Form->input('Database.name', array('label' => 'DB Name'));
		echo $this->Form->end('Install');
		?>
	</fieldset>
    <p>Server requirement : MySQL version 5.X+, PHP version 5.3+, Apache mod_rewrite</p>
</div>
</body>
</html>
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
	-webkit-appearance: button;
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
.floManagrLogoBlue {
	color: #4E86B9;
}
h1 {
	margin-top: 1em;
}
h4 {
	color: #3C0;
	font-size: 2em;
}
--> 
</style>

</head>
<body>

<?php echo $this->Session->flash(); ?>
<div class="install form">
    <h1>flo<span class="floManagrLogoBlue">Managr</span> Install</h1>
    <h4>Congratulations on the <br /> successful install!!!</h4>
  
<?php echo $this->Form->create('User', array('type' => 'file')); ?>
	<fieldset>
    	<legend><?php echo __('Administrator Account'); ?></legend>
		<p>Please create an administrator account login and keep your password in a secure and safe place.</p>
        <?php
		echo $this->Form->input('User.id', array('value' => $user['User']['id']));
		echo $this->Form->hidden('User.user_role_id', array('value' => $user['User']['user_role_id']));
		echo $this->Form->input('User.username', array('value' => $user['User']['username']));
		echo $this->Form->input('User.password', array('type' => 'password'));
		echo $this->Form->input('User.confirm_password', array('type' => 'password'));
		?>
    </fieldset>
	<fieldset>
    	<legend><?php echo __('Administrator info'); ?></legend>
        <?php
		echo $this->Form->input('User.full_name', array('value' => $user['User']['full_name']));
		echo $this->Form->input('User.email', array('value' => $user['User']['email']));
		echo $this->Form->end('Update');
		?>
    </fieldset>
    <br />
</div>
</body>
</html>
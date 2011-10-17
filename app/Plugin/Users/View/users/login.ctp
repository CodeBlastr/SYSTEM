<div class="login form">
  <h1><?php echo __('User Login', true); ?></h1>
  <?php
    echo $this->Form->create('User', array('action' => 'login'));
    echo $this->Form->input('username');
    echo $this->Form->input('password', array('label' => 'Password '));
    echo $this->Form->end('Login'); 
?>
  <div class="loginHelp"><?php echo $this->Html->link('Forgot Password?', array('plugin' => 'users', 'controller' => 'users', 'action' => 'forgot_password')); ?></div>
  <div class="registerHelp"><?php echo $this->Html->link('Register', array('plugin' => 'users', 'controller' => 'users', 'action' => 'register')); ?></div>
</div>
<?php 
// set the contextual menu items
$this->Menu->setValue(array(
	array(
		'heading' => 'Users',
		'items' => array(
			$this->Html->link(__('Register', true), array('plugin' => 'users', 'controller' => 'users', 'action' => 'register', 'admin' => 0)),
			)
		),
	));
?>
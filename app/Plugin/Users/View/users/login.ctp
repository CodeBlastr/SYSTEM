<div class="login form">
  <h1><?php echo __('User Login', true); ?></h1>
  <?php
    echo $form->create('User', array('action' => 'login'));
    echo $form->input('username');
    echo $form->input('password', array('label' => 'Password '));
    echo $form->end('Login'); 
?>
  <div class="loginHelp"><?php echo $this->Html->link('Forgot Password?', array('plugin' => 'users', 'controller' => 'users', 'action' => 'forgot_password')); ?></div>
  <div class="registerHelp"><?php echo $this->Html->link('Register', array('plugin' => 'users', 'controller' => 'users', 'action' => 'register')); ?></div>
</div>
<?php 
// set the contextual menu items
$menu->setValue(array(
	array(
		'heading' => 'Users',
		'items' => array(
			$this->Html->link(__('Register', true), array('plugin' => 'users', 'controller' => 'users', 'action' => 'register', 'admin' => 0)),
			)
		),
	));
?>
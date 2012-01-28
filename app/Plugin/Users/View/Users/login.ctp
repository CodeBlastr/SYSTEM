<div class="login form">
  <?php
    echo $this->Form->create('User', array('action' => 'login')); ?>
  <fieldset>
    <legend><h2><?php echo $this->Html->image('/images/logo.png') ? $this->Html->image('/images/logo.png') :  __('Login'); ?></h2></legend>
  <?php
    echo $this->Form->input('username');
    echo $this->Form->input('password', array('label' => 'Password '));
    echo $this->Form->end('Login'); 
?>
  <div class="loginHelp"><?php echo $this->Html->link('Forgot Password?', array('plugin' => 'users', 'controller' => 'users', 'action' => 'forgot_password')); ?></div>
  <div class="registerHelp"><?php echo $this->Html->link('Register', array('plugin' => 'users', 'controller' => 'users', 'action' => 'register')); ?></div>
</fieldset>
</div>
<?php 
/* set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Users',
		'items' => array(
			$this->Html->link(__('Register', true), array('plugin' => 'users', 'controller' => 'users', 'action' => 'register', 'admin' => 0)),
			)
		),
	)));*/
?>
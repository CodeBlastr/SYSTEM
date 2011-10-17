<h1><?php __('Reset Password', true); ?></h1>
<div class="users" id="forgotPassword">
<?php
    echo $this->Form->create('User');
    echo $this->Form->input('username', array('label' => 'Username or Email'));
    echo $this->Form->end('Submit');
?>
</div>

<?php 
// set the contextual menu items
$this->Menu->setValue(array(
	array(
		'heading' => 'Users',
		'items' => array(
			$this->Html->link(__('Register', true), array('plugin' => 'users', 'controller' => 'users', 'action' => 'add', 'admin' => 0)),
			)
		),
	));
?>
<h1><?php __('Reset Password', true); ?></h1>
<div class="users" id="forgotPassword">
<?php
    echo $form->create('User');
    echo $form->input('username', array('label' => 'Username or Email'));
    echo $form->end('Submit');
?>
</div>

<?php 
// set the contextual menu items
$menu->setValue(array(
	array(
		'heading' => 'Users',
		'items' => array(
			$html->link(__('Register', true), array('plugin' => 0, 'controller' => 'users', 'action' => 'add', 'admin' => 0)),
			)
		),
	));
?>
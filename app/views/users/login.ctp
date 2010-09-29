<div class="login">
<h1><?php echo __('Login', true); ?></h1>
<?php
    echo $form->create('User', array('action' => 'login'));
    echo $form->input('username');
    echo $form->input('password');
    echo $form->end('Login');
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
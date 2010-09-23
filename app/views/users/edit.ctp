<div id="user-add" class="users form">
    
<?php echo $form->create('User');?>
	<fieldset>
 		<legend><?php __('Edit User');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('username');
		echo $form->input('password', array('value' => ''));
		echo $form->input('user_group_id', array('type' => 'hidden'));
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>




<?php 
// set the contextual menu items
$menu->setValue(array(
	array(
		'heading' => 'Users',
		'items' => array(
			$html->link(__('Login', true), array('plugin' => 0, 'controller' => 'users', 'action' => 'login', 'admin' => 0)),
			)
		),
	));
?> 
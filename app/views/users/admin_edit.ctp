<div class="users form">
<?php echo $form->create('User');?>
	<fieldset>
 		<legend><?php __('Edit '.$form->value('User.username'));?></legend>
	<?php
		echo $form->input('User.id');
	if (!empty($this->params['named']['cpw'])) {
		echo $form->input('User.username', array('type' => 'hidden'));
		echo $form->input('User.user_group_id', array('type' => 'hidden'));
		echo $form->input('User.password', array('value' => ''));
		echo $form->input('User.confirm_password', array('value' => '', 'type' => 'password'));
	} else {
		echo $form->input('User.username');
		echo $form->input('User.email');
		echo $form->input('User.user_group_id');
	}
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
			 $html->link(__('Delete', true), array('action' => 'delete', $form->value('User.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('User.id'))),
			 $html->link(__('List Users', true), array('action' => 'index')),
			 $html->link(__('Change Password', true), array($form->value('User.id'), 'cpw' => 1)),
			 )
		),
	)
);
?>

<div class="users form">
<?php echo $form->create('User');?>
	<fieldset>
 		<legend><?php __('Edit '.$form->value('User.username'));?></legend>
	<?php
		echo $form->input('User.id');
	if (!empty($this->params['named']['cpw'])) {
		echo $form->input('User.username', array('type' => 'hidden'));
		echo $form->input('User.user_role_id', array('type' => 'hidden'));
		echo $form->input('User.password', array('value' => ''));
		echo $form->input('User.confirm_password', array('value' => '', 'type' => 'password'));
	} else {
		echo $form->input('User.username');
		echo $form->input('User.email');
		echo $form->input('User.user_role_id');
		echo $form->input('User.credit_total');
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
			 $this->Html->link(__('Delete', true), array('action' => 'delete', $form->value('User.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('User.id'))),
			 $this->Html->link(__('List Users', true), array('action' => 'index')),
			 $this->Html->link(__('Change Password', true), array($form->value('User.id'), 'cpw' => 1)),
			 )
		),
	)
);
?>

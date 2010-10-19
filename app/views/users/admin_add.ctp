Not available yet take from RFDF 
<div class="users form">
<?php echo $form->create('User');?>
	<fieldset>
 		<legend><?php __('Add User');?></legend>
	<?php
		echo $form->input('username');
		echo $form->input('User.email');
		echo $form->input('User.password', array('value' => ''));
		echo $form->input('User.confirm_password', array('value' => '', 'type' => 'password'));
		echo $form->input('user_group_id');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List Users', true), array('action' => 'index'));?></li>
	</ul>
</div>
Not available yet take from RFDF 
<div class="users form">
<?php echo $this->Form->create('User');?>
	<fieldset>
 		<legend><?php __('Add User');?></legend>
	<?php
		echo $this->Form->input('username');
		echo $this->Form->input('User.email');
		echo $this->Form->input('User.password', array('value' => ''));
		echo $this->Form->input('User.confirm_password', array('value' => '', 'type' => 'password'));
		echo $this->Form->input('user_role_id');
	?>
	</fieldset>
<?php echo $this->Form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('List Users', true), array('action' => 'index'));?></li>
	</ul>
</div>
<div class="users form">
<?php echo $this->Form->create('User');?>
	<fieldset>
 		<legend><?php __('Edit '.$this->Form->value('User.username'));?></legend>
	<?php
		echo $this->Form->input('User.id');
	if (!empty($this->params['named']['cpw'])) {
		echo $this->Form->input('User.username', array('type' => 'hidden'));
		echo $this->Form->input('User.user_role_id', array('type' => 'hidden'));
		echo $this->Form->input('User.password', array('value' => ''));
		echo $this->Form->input('User.confirm_password', array('value' => '', 'type' => 'password'));
	} else {
		echo $this->Form->input('User.username');
		echo $this->Form->input('User.email');
		echo $this->Form->input('User.user_role_id');
		echo $this->Form->input('User.credit_total');
	}
	?>
	</fieldset>
<?php echo $this->Form->end('Submit');?>
</div>

<?php 
// set the contextual menu items
$this->Menu->setValue(array(
	array(
		'heading' => 'Users',
		'items' => array(
			 $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('User.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('User.id'))),
			 $this->Html->link(__('List Users', true), array('action' => 'index')),
			 $this->Html->link(__('Change Password', true), array($this->Form->value('User.id'), 'cpw' => 1)),
			 )
		),
	)
);
?>

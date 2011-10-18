<div class="UsersUserGroups form">
<?php echo $this->Form->create('UsersUserGroup');?>
	<fieldset>
 		<legend><?php __('Admin Add Users User Goup'); ?></legend>
	<?php
		echo $this->Form->input('user_id');
		echo $this->Form->input('user_group_id');
		echo $this->Form->input('is_approved');
		echo $this->Form->input('is_moderator');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Users User Goups', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List User Groups', true), array('controller' => 'user_groups', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User Group', true), array('controller' => 'user_groups', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="userStatuses form">
<?php echo $this->Form->create('UserStatus');?>
	<fieldset>
 		<legend><?php __('Admin Add User Status'); ?></legend>
	<?php
		echo $this->Form->input('status');
		echo $this->Form->input('creator_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List User Statuses', true), array('action' => 'index'));?></li>
	</ul>
</div>
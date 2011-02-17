<div class="estimates form">
<?php echo $this->Form->create('Estimate');?>
	<fieldset>
 		<legend><?php __('Admin Add Estimate'); ?></legend>
	<?php
		echo $this->Form->input('estimate_type_id');
		echo $this->Form->input('estimate_status_id');
		echo $this->Form->input('name');
		echo $this->Form->input('introduction');
		echo $this->Form->input('conclusion');
		echo $this->Form->input('expiration_date');
		echo $this->Form->input('total');
		echo $this->Form->input('is_accepted');
		echo $this->Form->input('is_archived');
		echo $this->Form->input('recipient_id');
		echo $this->Form->input('creator_id');
		echo $this->Form->input('modifier_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Estimates', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Enumerations', true), array('controller' => 'enumerations', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Estimate Type', true), array('controller' => 'enumerations', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Recipient', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Estimateds', true), array('controller' => 'estimateds', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Estimated', true), array('controller' => 'estimateds', 'action' => 'add')); ?> </li>
	</ul>
</div>
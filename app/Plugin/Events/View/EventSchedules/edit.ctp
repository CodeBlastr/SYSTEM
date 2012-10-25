<div class="eventSchedules form">
<?php echo $this->Form->create('EventSchedule');?>
	<fieldset>
		<legend><?php echo __('Edit Event Schedule'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('repeat_on');
		echo $this->Form->input('repeat_every');
		echo $this->Form->input('start');
		echo $this->Form->input('end');
		echo $this->Form->input('creator_id');
		echo $this->Form->input('modifier_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('EventSchedule.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('EventSchedule.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Event Schedules'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Events'), array('controller' => 'events', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Event'), array('controller' => 'events', 'action' => 'add')); ?> </li>
	</ul>
</div>

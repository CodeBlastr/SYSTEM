<div class="eventVenues form">
<?php echo $this->Form->create('EventVenue');?>
	<fieldset>
		<legend><?php echo __('Edit Event Venue'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('parent_id');
		echo $this->Form->input('lft');
		echo $this->Form->input('rght');
		echo $this->Form->input('event_id');
		echo $this->Form->input('name');
		echo $this->Form->input('description');
		echo $this->Form->input('tickets_total');
		echo $this->Form->input('tickets_left');
		echo $this->Form->input('ticket_price');
		echo $this->Form->input('creator_id');
		echo $this->Form->input('modifier_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('EventVenue.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('EventVenue.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Event Venues'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Event Venues'), array('controller' => 'event_venues', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Parent Event Venue'), array('controller' => 'event_venues', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Events'), array('controller' => 'events', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Event'), array('controller' => 'events', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Events Guests'), array('controller' => 'events_guests', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Events Guest'), array('controller' => 'events_guests', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Event Seats'), array('controller' => 'event_seats', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Event Seat'), array('controller' => 'event_seats', 'action' => 'add')); ?> </li>
	</ul>
</div>

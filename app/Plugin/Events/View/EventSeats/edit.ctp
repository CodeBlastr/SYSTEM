<div class="eventSeats form">
<?php echo $this->Form->create('EventSeat');?>
	<fieldset>
		<legend><?php echo __('Edit Event Seat'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('event_venue_id');
		echo $this->Form->input('name');
		echo $this->Form->input('description');
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

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('EventSeat.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('EventSeat.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Event Seats'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Event Venues'), array('controller' => 'event_venues', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Event Venue'), array('controller' => 'event_venues', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Events Guests'), array('controller' => 'events_guests', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Event Guest'), array('controller' => 'events_guests', 'action' => 'add')); ?> </li>
	</ul>
</div>

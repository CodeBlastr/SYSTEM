<div class="eventSeats view">
<h2><?php  echo __('Event Seat');?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($eventSeat['EventSeat']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Event Venue'); ?></dt>
		<dd>
			<?php echo $this->Html->link($eventSeat['EventVenue']['name'], array('controller' => 'event_venues', 'action' => 'view', $eventSeat['EventVenue']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($eventSeat['EventSeat']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($eventSeat['EventSeat']['description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Ticket Price'); ?></dt>
		<dd>
			<?php echo h($eventSeat['EventSeat']['ticket_price']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Creator Id'); ?></dt>
		<dd>
			<?php echo h($eventSeat['EventSeat']['creator_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modifier Id'); ?></dt>
		<dd>
			<?php echo h($eventSeat['EventSeat']['modifier_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($eventSeat['EventSeat']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($eventSeat['EventSeat']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Event Seat'), array('action' => 'edit', $eventSeat['EventSeat']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Event Seat'), array('action' => 'delete', $eventSeat['EventSeat']['id']), null, __('Are you sure you want to delete # %s?', $eventSeat['EventSeat']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Event Seats'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Event Seat'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Event Venues'), array('controller' => 'event_venues', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Event Venue'), array('controller' => 'event_venues', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Events Guests'), array('controller' => 'events_guests', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Event Guest'), array('controller' => 'events_guests', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Events Guests');?></h3>
	<?php if (!empty($eventSeat['EventGuest'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Event Id'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Email'); ?></th>
		<th><?php echo __('Event Venue Id'); ?></th>
		<th><?php echo __('Event Seat Id'); ?></th>
		<th><?php echo __('Creator Id'); ?></th>
		<th><?php echo __('Modifier Id'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($eventSeat['EventGuest'] as $eventGuest): ?>
		<tr>
			<td><?php echo $eventGuest['id'];?></td>
			<td><?php echo $eventGuest['event_id'];?></td>
			<td><?php echo $eventGuest['user_id'];?></td>
			<td><?php echo $eventGuest['email'];?></td>
			<td><?php echo $eventGuest['event_venue_id'];?></td>
			<td><?php echo $eventGuest['event_seat_id'];?></td>
			<td><?php echo $eventGuest['creator_id'];?></td>
			<td><?php echo $eventGuest['modifier_id'];?></td>
			<td><?php echo $eventGuest['created'];?></td>
			<td><?php echo $eventGuest['modified'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'events_guests', 'action' => 'view', $eventGuest['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'events_guests', 'action' => 'edit', $eventGuest['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'events_guests', 'action' => 'delete', $eventGuest['id']), null, __('Are you sure you want to delete # %s?', $eventGuest['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Event Guest'), array('controller' => 'events_guests', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>

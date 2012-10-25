<div class="eventVenues view">
<h2><?php  echo __('Event Venue');?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($eventVenue['EventVenue']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Parent Event Venue'); ?></dt>
		<dd>
			<?php echo $this->Html->link($eventVenue['ParentEventVenue']['name'], array('controller' => 'event_venues', 'action' => 'view', $eventVenue['ParentEventVenue']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Lft'); ?></dt>
		<dd>
			<?php echo h($eventVenue['EventVenue']['lft']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Rght'); ?></dt>
		<dd>
			<?php echo h($eventVenue['EventVenue']['rght']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Event'); ?></dt>
		<dd>
			<?php echo $this->Html->link($eventVenue['Event']['name'], array('controller' => 'events', 'action' => 'view', $eventVenue['Event']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($eventVenue['EventVenue']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($eventVenue['EventVenue']['description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Tickets Total'); ?></dt>
		<dd>
			<?php echo h($eventVenue['EventVenue']['tickets_total']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Tickets Left'); ?></dt>
		<dd>
			<?php echo h($eventVenue['EventVenue']['tickets_left']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Ticket Price'); ?></dt>
		<dd>
			<?php echo h($eventVenue['EventVenue']['ticket_price']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Creator Id'); ?></dt>
		<dd>
			<?php echo h($eventVenue['EventVenue']['creator_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modifier Id'); ?></dt>
		<dd>
			<?php echo h($eventVenue['EventVenue']['modifier_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($eventVenue['EventVenue']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($eventVenue['EventVenue']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Event Venue'), array('action' => 'edit', $eventVenue['EventVenue']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Event Venue'), array('action' => 'delete', $eventVenue['EventVenue']['id']), null, __('Are you sure you want to delete # %s?', $eventVenue['EventVenue']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Event Venues'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Event Venue'), array('action' => 'add')); ?> </li>
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
<div class="related">
	<h3><?php echo __('Related Events Guests');?></h3>
	<?php if (!empty($eventVenue['EventsGuest'])):?>
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
		foreach ($eventVenue['EventsGuest'] as $eventsGuest): ?>
		<tr>
			<td><?php echo $eventsGuest['id'];?></td>
			<td><?php echo $eventsGuest['event_id'];?></td>
			<td><?php echo $eventsGuest['user_id'];?></td>
			<td><?php echo $eventsGuest['email'];?></td>
			<td><?php echo $eventsGuest['event_venue_id'];?></td>
			<td><?php echo $eventsGuest['event_seat_id'];?></td>
			<td><?php echo $eventsGuest['creator_id'];?></td>
			<td><?php echo $eventsGuest['modifier_id'];?></td>
			<td><?php echo $eventsGuest['created'];?></td>
			<td><?php echo $eventsGuest['modified'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'events_guests', 'action' => 'view', $eventsGuest['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'events_guests', 'action' => 'edit', $eventsGuest['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'events_guests', 'action' => 'delete', $eventsGuest['id']), null, __('Are you sure you want to delete # %s?', $eventsGuest['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Events Guest'), array('controller' => 'events_guests', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Event Seats');?></h3>
	<?php if (!empty($eventVenue['EventSeat'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Event Venue Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Description'); ?></th>
		<th><?php echo __('Ticket Price'); ?></th>
		<th><?php echo __('Creator Id'); ?></th>
		<th><?php echo __('Modifier Id'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($eventVenue['EventSeat'] as $eventSeat): ?>
		<tr>
			<td><?php echo $eventSeat['id'];?></td>
			<td><?php echo $eventSeat['event_venue_id'];?></td>
			<td><?php echo $eventSeat['name'];?></td>
			<td><?php echo $eventSeat['description'];?></td>
			<td><?php echo $eventSeat['ticket_price'];?></td>
			<td><?php echo $eventSeat['creator_id'];?></td>
			<td><?php echo $eventSeat['modifier_id'];?></td>
			<td><?php echo $eventSeat['created'];?></td>
			<td><?php echo $eventSeat['modified'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'event_seats', 'action' => 'view', $eventSeat['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'event_seats', 'action' => 'edit', $eventSeat['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'event_seats', 'action' => 'delete', $eventSeat['id']), null, __('Are you sure you want to delete # %s?', $eventSeat['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Event Seat'), array('controller' => 'event_seats', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Event Venues');?></h3>
	<?php if (!empty($eventVenue['ChildEventVenue'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Parent Id'); ?></th>
		<th><?php echo __('Lft'); ?></th>
		<th><?php echo __('Rght'); ?></th>
		<th><?php echo __('Event Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Description'); ?></th>
		<th><?php echo __('Tickets Total'); ?></th>
		<th><?php echo __('Tickets Left'); ?></th>
		<th><?php echo __('Ticket Price'); ?></th>
		<th><?php echo __('Creator Id'); ?></th>
		<th><?php echo __('Modifier Id'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($eventVenue['ChildEventVenue'] as $childEventVenue): ?>
		<tr>
			<td><?php echo $childEventVenue['id'];?></td>
			<td><?php echo $childEventVenue['parent_id'];?></td>
			<td><?php echo $childEventVenue['lft'];?></td>
			<td><?php echo $childEventVenue['rght'];?></td>
			<td><?php echo $childEventVenue['event_id'];?></td>
			<td><?php echo $childEventVenue['name'];?></td>
			<td><?php echo $childEventVenue['description'];?></td>
			<td><?php echo $childEventVenue['tickets_total'];?></td>
			<td><?php echo $childEventVenue['tickets_left'];?></td>
			<td><?php echo $childEventVenue['ticket_price'];?></td>
			<td><?php echo $childEventVenue['creator_id'];?></td>
			<td><?php echo $childEventVenue['modifier_id'];?></td>
			<td><?php echo $childEventVenue['created'];?></td>
			<td><?php echo $childEventVenue['modified'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'event_venues', 'action' => 'view', $childEventVenue['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'event_venues', 'action' => 'edit', $childEventVenue['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'event_venues', 'action' => 'delete', $childEventVenue['id']), null, __('Are you sure you want to delete # %s?', $childEventVenue['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Child Event Venue'), array('controller' => 'event_venues', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>

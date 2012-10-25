<div class="events view">
<h2><?php  echo __('Event');?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($event['Event']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Event Schedule'); ?></dt>
		<dd>
			<?php echo $this->Html->link($event['EventSchedule']['id'], array('controller' => 'event_schedules', 'action' => 'view', $event['EventSchedule']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($event['Event']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($event['Event']['description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Start'); ?></dt>
		<dd>
			<?php echo h($event['Event']['start']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('End'); ?></dt>
		<dd>
			<?php echo h($event['Event']['end']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Tickets Total'); ?></dt>
		<dd>
			<?php echo h($event['Event']['tickets_total']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Tickets Left'); ?></dt>
		<dd>
			<?php echo h($event['Event']['tickets_left']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Ticket Price'); ?></dt>
		<dd>
			<?php echo h($event['Event']['ticket_price']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Is Public'); ?></dt>
		<dd>
			<?php echo h($event['Event']['is_public']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Creator Id'); ?></dt>
		<dd>
			<?php echo h($event['Event']['creator_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modifier Id'); ?></dt>
		<dd>
			<?php echo h($event['Event']['modifier_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($event['Event']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($event['Event']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Event'), array('action' => 'edit', $event['Event']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Event'), array('action' => 'delete', $event['Event']['id']), null, __('Are you sure you want to delete # %s?', $event['Event']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Events'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Event'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Event Schedules'), array('controller' => 'event_schedules', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Event Schedule'), array('controller' => 'event_schedules', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Event Venues'), array('controller' => 'event_venues', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Event Venue'), array('controller' => 'event_venues', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Events Guests'), array('controller' => 'events_guests', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Guest'), array('controller' => 'events_guests', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Event Venues');?></h3>
	<?php if (!empty($event['EventVenue'])):?>
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
		foreach ($event['EventVenue'] as $eventVenue): ?>
		<tr>
			<td><?php echo $eventVenue['id'];?></td>
			<td><?php echo $eventVenue['parent_id'];?></td>
			<td><?php echo $eventVenue['lft'];?></td>
			<td><?php echo $eventVenue['rght'];?></td>
			<td><?php echo $eventVenue['event_id'];?></td>
			<td><?php echo $eventVenue['name'];?></td>
			<td><?php echo $eventVenue['description'];?></td>
			<td><?php echo $eventVenue['tickets_total'];?></td>
			<td><?php echo $eventVenue['tickets_left'];?></td>
			<td><?php echo $eventVenue['ticket_price'];?></td>
			<td><?php echo $eventVenue['creator_id'];?></td>
			<td><?php echo $eventVenue['modifier_id'];?></td>
			<td><?php echo $eventVenue['created'];?></td>
			<td><?php echo $eventVenue['modified'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'event_venues', 'action' => 'view', $eventVenue['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'event_venues', 'action' => 'edit', $eventVenue['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'event_venues', 'action' => 'delete', $eventVenue['id']), null, __('Are you sure you want to delete # %s?', $eventVenue['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Event Venue'), array('controller' => 'event_venues', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Events Guests');?></h3>
	<?php if (!empty($event['Guest'])):?>
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
		foreach ($event['Guest'] as $guest): ?>
		<tr>
			<td><?php echo $guest['id'];?></td>
			<td><?php echo $guest['event_id'];?></td>
			<td><?php echo $guest['user_id'];?></td>
			<td><?php echo $guest['email'];?></td>
			<td><?php echo $guest['event_venue_id'];?></td>
			<td><?php echo $guest['event_seat_id'];?></td>
			<td><?php echo $guest['creator_id'];?></td>
			<td><?php echo $guest['modifier_id'];?></td>
			<td><?php echo $guest['created'];?></td>
			<td><?php echo $guest['modified'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'events_guests', 'action' => 'view', $guest['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'events_guests', 'action' => 'edit', $guest['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'events_guests', 'action' => 'delete', $guest['id']), null, __('Are you sure you want to delete # %s?', $guest['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Guest'), array('controller' => 'events_guests', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>

<div class="eventsGuests index">
	<h2><?php echo __('Events Guests');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('event_id');?></th>
			<th><?php echo $this->Paginator->sort('user_id');?></th>
			<th><?php echo $this->Paginator->sort('email');?></th>
			<th><?php echo $this->Paginator->sort('event_venue_id');?></th>
			<th><?php echo $this->Paginator->sort('event_seat_id');?></th>
			<th><?php echo $this->Paginator->sort('creator_id');?></th>
			<th><?php echo $this->Paginator->sort('modifier_id');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	foreach ($eventsGuests as $eventsGuest): ?>
	<tr>
		<td><?php echo h($eventsGuest['EventsGuest']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($eventsGuest['Event']['name'], array('controller' => 'events', 'action' => 'view', $eventsGuest['Event']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($eventsGuest['User']['full_name'], array('controller' => 'users', 'action' => 'view', $eventsGuest['User']['id'])); ?>
		</td>
		<td><?php echo h($eventsGuest['EventsGuest']['email']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($eventsGuest['EventVenue']['name'], array('controller' => 'event_venues', 'action' => 'view', $eventsGuest['EventVenue']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($eventsGuest['EventSeat']['name'], array('controller' => 'event_seats', 'action' => 'view', $eventsGuest['EventSeat']['id'])); ?>
		</td>
		<td><?php echo h($eventsGuest['EventsGuest']['creator_id']); ?>&nbsp;</td>
		<td><?php echo h($eventsGuest['EventsGuest']['modifier_id']); ?>&nbsp;</td>
		<td><?php echo h($eventsGuest['EventsGuest']['created']); ?>&nbsp;</td>
		<td><?php echo h($eventsGuest['EventsGuest']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $eventsGuest['EventsGuest']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $eventsGuest['EventsGuest']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $eventsGuest['EventsGuest']['id']), null, __('Are you sure you want to delete # %s?', $eventsGuest['EventsGuest']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>

	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Events Guest'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Events'), array('controller' => 'events', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Event'), array('controller' => 'events', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Event Venues'), array('controller' => 'event_venues', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Event Venue'), array('controller' => 'event_venues', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Event Seats'), array('controller' => 'event_seats', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Event Seat'), array('controller' => 'event_seats', 'action' => 'add')); ?> </li>
	</ul>
</div>

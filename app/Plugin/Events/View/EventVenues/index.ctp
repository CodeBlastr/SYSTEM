<div class="eventVenues index">
	<h2><?php echo __('Event Venues');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('parent_id');?></th>
			<th><?php echo $this->Paginator->sort('lft');?></th>
			<th><?php echo $this->Paginator->sort('rght');?></th>
			<th><?php echo $this->Paginator->sort('event_id');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('description');?></th>
			<th><?php echo $this->Paginator->sort('tickets_total');?></th>
			<th><?php echo $this->Paginator->sort('tickets_left');?></th>
			<th><?php echo $this->Paginator->sort('ticket_price');?></th>
			<th><?php echo $this->Paginator->sort('creator_id');?></th>
			<th><?php echo $this->Paginator->sort('modifier_id');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	foreach ($eventVenues as $eventVenue): ?>
	<tr>
		<td><?php echo h($eventVenue['EventVenue']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($eventVenue['ParentEventVenue']['name'], array('controller' => 'event_venues', 'action' => 'view', $eventVenue['ParentEventVenue']['id'])); ?>
		</td>
		<td><?php echo h($eventVenue['EventVenue']['lft']); ?>&nbsp;</td>
		<td><?php echo h($eventVenue['EventVenue']['rght']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($eventVenue['Event']['name'], array('controller' => 'events', 'action' => 'view', $eventVenue['Event']['id'])); ?>
		</td>
		<td><?php echo h($eventVenue['EventVenue']['name']); ?>&nbsp;</td>
		<td><?php echo h($eventVenue['EventVenue']['description']); ?>&nbsp;</td>
		<td><?php echo h($eventVenue['EventVenue']['tickets_total']); ?>&nbsp;</td>
		<td><?php echo h($eventVenue['EventVenue']['tickets_left']); ?>&nbsp;</td>
		<td><?php echo h($eventVenue['EventVenue']['ticket_price']); ?>&nbsp;</td>
		<td><?php echo h($eventVenue['EventVenue']['creator_id']); ?>&nbsp;</td>
		<td><?php echo h($eventVenue['EventVenue']['modifier_id']); ?>&nbsp;</td>
		<td><?php echo h($eventVenue['EventVenue']['created']); ?>&nbsp;</td>
		<td><?php echo h($eventVenue['EventVenue']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $eventVenue['EventVenue']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $eventVenue['EventVenue']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $eventVenue['EventVenue']['id']), null, __('Are you sure you want to delete # %s?', $eventVenue['EventVenue']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Event Venue'), array('action' => 'add')); ?></li>
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

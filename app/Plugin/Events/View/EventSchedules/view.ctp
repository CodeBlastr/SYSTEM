<div class="eventSchedules view">
<h2><?php  echo __('Event Schedule');?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($eventSchedule['EventSchedule']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Repeat On'); ?></dt>
		<dd>
			<?php echo h($eventSchedule['EventSchedule']['repeat_on']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Repeat Every'); ?></dt>
		<dd>
			<?php echo h($eventSchedule['EventSchedule']['repeat_every']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Start'); ?></dt>
		<dd>
			<?php echo h($eventSchedule['EventSchedule']['start']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('End'); ?></dt>
		<dd>
			<?php echo h($eventSchedule['EventSchedule']['end']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Creator Id'); ?></dt>
		<dd>
			<?php echo h($eventSchedule['EventSchedule']['creator_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modifier Id'); ?></dt>
		<dd>
			<?php echo h($eventSchedule['EventSchedule']['modifier_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($eventSchedule['EventSchedule']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($eventSchedule['EventSchedule']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Event Schedule'), array('action' => 'edit', $eventSchedule['EventSchedule']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Event Schedule'), array('action' => 'delete', $eventSchedule['EventSchedule']['id']), null, __('Are you sure you want to delete # %s?', $eventSchedule['EventSchedule']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Event Schedules'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Event Schedule'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Events'), array('controller' => 'events', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Event'), array('controller' => 'events', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Events');?></h3>
	<?php if (!empty($eventSchedule['Event'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Event Schedule Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Description'); ?></th>
		<th><?php echo __('Start'); ?></th>
		<th><?php echo __('End'); ?></th>
		<th><?php echo __('Tickets Total'); ?></th>
		<th><?php echo __('Tickets Left'); ?></th>
		<th><?php echo __('Ticket Price'); ?></th>
		<th><?php echo __('Is Public'); ?></th>
		<th><?php echo __('Creator Id'); ?></th>
		<th><?php echo __('Modifier Id'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($eventSchedule['Event'] as $event): ?>
		<tr>
			<td><?php echo $event['id'];?></td>
			<td><?php echo $event['event_schedule_id'];?></td>
			<td><?php echo $event['name'];?></td>
			<td><?php echo $event['description'];?></td>
			<td><?php echo $event['start'];?></td>
			<td><?php echo $event['end'];?></td>
			<td><?php echo $event['tickets_total'];?></td>
			<td><?php echo $event['tickets_left'];?></td>
			<td><?php echo $event['ticket_price'];?></td>
			<td><?php echo $event['is_public'];?></td>
			<td><?php echo $event['creator_id'];?></td>
			<td><?php echo $event['modifier_id'];?></td>
			<td><?php echo $event['created'];?></td>
			<td><?php echo $event['modified'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'events', 'action' => 'view', $event['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'events', 'action' => 'edit', $event['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'events', 'action' => 'delete', $event['id']), null, __('Are you sure you want to delete # %s?', $event['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Event'), array('controller' => 'events', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>

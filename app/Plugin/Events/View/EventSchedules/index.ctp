<div class="eventSchedules index">
	<h2><?php echo __('Event Schedules');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('repeat_on');?></th>
			<th><?php echo $this->Paginator->sort('repeat_every');?></th>
			<th><?php echo $this->Paginator->sort('start');?></th>
			<th><?php echo $this->Paginator->sort('end');?></th>
			<th><?php echo $this->Paginator->sort('creator_id');?></th>
			<th><?php echo $this->Paginator->sort('modifier_id');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	foreach ($eventSchedules as $eventSchedule): ?>
	<tr>
		<td><?php echo h($eventSchedule['EventSchedule']['id']); ?>&nbsp;</td>
		<td><?php echo h($eventSchedule['EventSchedule']['repeat_on']); ?>&nbsp;</td>
		<td><?php echo h($eventSchedule['EventSchedule']['repeat_every']); ?>&nbsp;</td>
		<td><?php echo h($eventSchedule['EventSchedule']['start']); ?>&nbsp;</td>
		<td><?php echo h($eventSchedule['EventSchedule']['end']); ?>&nbsp;</td>
		<td><?php echo h($eventSchedule['EventSchedule']['creator_id']); ?>&nbsp;</td>
		<td><?php echo h($eventSchedule['EventSchedule']['modifier_id']); ?>&nbsp;</td>
		<td><?php echo h($eventSchedule['EventSchedule']['created']); ?>&nbsp;</td>
		<td><?php echo h($eventSchedule['EventSchedule']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $eventSchedule['EventSchedule']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $eventSchedule['EventSchedule']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $eventSchedule['EventSchedule']['id']), null, __('Are you sure you want to delete # %s?', $eventSchedule['EventSchedule']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Event Schedule'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Events'), array('controller' => 'events', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Event'), array('controller' => 'events', 'action' => 'add')); ?> </li>
	</ul>
</div>

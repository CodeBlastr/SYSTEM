<div class="timesheets index">
<h2><?php __('Timesheets');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort('name');?></th>
	<th><?php echo $paginator->sort('creator_id');?></th>
	<th><?php echo $paginator->sort('modifier_id');?></th>
	<th><?php echo $paginator->sort('created');?></th>
	<th><?php echo $paginator->sort('modified');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($timesheets as $timesheet):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $timesheet['Timesheet']['id']; ?>
		</td>
		<td>
			<?php echo $timesheet['Timesheet']['name']; ?>
		</td>
		<td>
			<?php echo $html->link($timesheet['Creator']['username'], array('controller' => 'users', 'action' => 'view', $timesheet['Creator']['id'])); ?>
		</td>
		<td>
			<?php echo $html->link($timesheet['Modifier']['username'], array('controller' => 'users', 'action' => 'view', $timesheet['Modifier']['id'])); ?>
		</td>
		<td>
			<?php echo $timesheet['Timesheet']['created']; ?>
		</td>
		<td>
			<?php echo $timesheet['Timesheet']['modified']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action' => 'view', $timesheet['Timesheet']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action' => 'edit', $timesheet['Timesheet']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action' => 'delete', $timesheet['Timesheet']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $timesheet['Timesheet']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<div class="paging">
	<?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('next', true).' >>', array(), null, array('class' => 'disabled'));?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('New Timesheet', true), array('action' => 'add')); ?></li>
		<li><?php echo $html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Creator', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('List Timesheet Times', true), array('controller' => 'timesheet_times', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Timesheet Time', true), array('controller' => 'timesheet_times', 'action' => 'add')); ?> </li>
	</ul>
</div>

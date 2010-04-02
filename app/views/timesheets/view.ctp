<div class="timesheets view">
<h2><?php  __('Timesheet');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $timesheet['Timesheet']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $timesheet['Timesheet']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Creator'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($timesheet['Creator']['username'], array('controller' => 'users', 'action' => 'view', $timesheet['Creator']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modifier'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($timesheet['Modifier']['username'], array('controller' => 'users', 'action' => 'view', $timesheet['Modifier']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $timesheet['Timesheet']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $timesheet['Timesheet']['modified']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit Timesheet', true), array('action' => 'edit', $timesheet['Timesheet']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete Timesheet', true), array('action' => 'delete', $timesheet['Timesheet']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $timesheet['Timesheet']['id'])); ?> </li>
		<li><?php echo $html->link(__('List Timesheets', true), array('action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Timesheet', true), array('action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Creator', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('List Timesheet Times', true), array('controller' => 'timesheet_times', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Timesheet Time', true), array('controller' => 'timesheet_times', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Timesheet Times');?></h3>
	<?php if (!empty($timesheet['TimesheetTime'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Hours'); ?></th>
		<th><?php __('Comments'); ?></th>
		<th><?php __('Started On'); ?></th>
		<th><?php __('Project Id'); ?></th>
		<th><?php __('Project Issue Id'); ?></th>
		<th><?php __('Creator Id'); ?></th>
		<th><?php __('Modifier Id'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($timesheet['TimesheetTime'] as $timesheetTime):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $timesheetTime['id'];?></td>
			<td><?php echo $timesheetTime['hours'];?></td>
			<td><?php echo $timesheetTime['comments'];?></td>
			<td><?php echo $timesheetTime['started_on'];?></td>
			<td><?php echo $timesheetTime['project_id'];?></td>
			<td><?php echo $timesheetTime['project_issue_id'];?></td>
			<td><?php echo $timesheetTime['creator_id'];?></td>
			<td><?php echo $timesheetTime['modifier_id'];?></td>
			<td><?php echo $timesheetTime['created'];?></td>
			<td><?php echo $timesheetTime['modified'];?></td>
			<td class="actions">
				<?php echo $html->link(__('View', true), array('controller' => 'timesheet_times', 'action' => 'view', $timesheetTime['id'])); ?>
				<?php echo $html->link(__('Edit', true), array('controller' => 'timesheet_times', 'action' => 'edit', $timesheetTime['id'])); ?>
				<?php echo $html->link(__('Delete', true), array('controller' => 'timesheet_times', 'action' => 'delete', $timesheetTime['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $timesheetTime['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $html->link(__('New Timesheet Time', true), array('controller' => 'timesheet_times', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>

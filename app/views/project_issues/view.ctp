<div class="projectIssues view">
<h2><?php  __('ProjectIssue');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $projectIssue['ProjectIssue']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Project Issue Parent'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($projectIssue['ProjectIssueParent']['name'], array('controller' => 'project_issues', 'action' => 'view', $projectIssue['ProjectIssueParent']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Project Issue Type'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($projectIssue['ProjectStatusType']['name'], array('controller' => 'contact_activity_types', 'action' => 'view', $projectIssue['ProjectStatusType']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $projectIssue['ProjectIssue']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Description'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $projectIssue['ProjectIssue']['description']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Project'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($projectIssue['Project']['id'], array('controller' => 'projects', 'action' => 'view', $projectIssue['Project']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Creator'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($projectIssue['Creator']['id'], array('controller' => 'users', 'action' => 'view', $projectIssue['Creator']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modifier Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $projectIssue['ProjectIssue']['modifier_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $projectIssue['ProjectIssue']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $projectIssue['ProjectIssue']['modified']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit ProjectIssue', true), array('action' => 'edit', $projectIssue['ProjectIssue']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete ProjectIssue', true), array('action' => 'delete', $projectIssue['ProjectIssue']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $projectIssue['ProjectIssue']['id'])); ?> </li>
		<li><?php echo $html->link(__('List ProjectIssues', true), array('action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New ProjectIssue', true), array('action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('List Project Issues', true), array('controller' => 'project_issues', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Project Issue Parent', true), array('controller' => 'project_issues', 'action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('List Project Issue Types', true), array('controller' => 'contact_activity_types', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Project Issue Type', true), array('controller' => 'contact_activity_types', 'action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Creator', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('List Projects', true), array('controller' => 'projects', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Project', true), array('controller' => 'projects', 'action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('List Project Issue Media', true), array('controller' => 'contact_activity_media', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Project Issue Medium', true), array('controller' => 'contact_activity_media', 'action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('List Project Issue User Groups', true), array('controller' => 'contact_activity_user_groups', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Project Issue User Group', true), array('controller' => 'contact_activity_user_groups', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Project Issue Media');?></h3>
	<?php if (!empty($projectIssue['ProjectIssueMedium'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Medium Id'); ?></th>
		<th><?php __('Project Issue Id'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($projectIssue['ProjectIssueMedium'] as $projectIssueMedium):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $projectIssueMedium['id'];?></td>
			<td><?php echo $projectIssueMedium['medium_id'];?></td>
			<td><?php echo $projectIssueMedium['contact_activity_id'];?></td>
			<td><?php echo $projectIssueMedium['created'];?></td>
			<td><?php echo $projectIssueMedium['modified'];?></td>
			<td class="actions">
				<?php echo $html->link(__('View', true), array('controller' => 'contact_activity_media', 'action' => 'view', $projectIssueMedium['id'])); ?>
				<?php echo $html->link(__('Edit', true), array('controller' => 'contact_activity_media', 'action' => 'edit', $projectIssueMedium['id'])); ?>
				<?php echo $html->link(__('Delete', true), array('controller' => 'contact_activity_media', 'action' => 'delete', $projectIssueMedium['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $projectIssueMedium['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $html->link(__('New Project Issue Medium', true), array('controller' => 'contact_activity_media', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php __('Related Project Issue User Groups');?></h3>
	<?php if (!empty($projectIssue['ProjectIssueUserGroup'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('User Group Id'); ?></th>
		<th><?php __('Project Issue Id'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($projectIssue['ProjectIssueUserGroup'] as $projectIssueUserGroup):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $projectIssueUserGroup['id'];?></td>
			<td><?php echo $projectIssueUserGroup['user_group_id'];?></td>
			<td><?php echo $projectIssueUserGroup['contact_activity_id'];?></td>
			<td><?php echo $projectIssueUserGroup['created'];?></td>
			<td><?php echo $projectIssueUserGroup['modified'];?></td>
			<td class="actions">
				<?php echo $html->link(__('View', true), array('controller' => 'contact_activity_user_groups', 'action' => 'view', $projectIssueUserGroup['id'])); ?>
				<?php echo $html->link(__('Edit', true), array('controller' => 'contact_activity_user_groups', 'action' => 'edit', $projectIssueUserGroup['id'])); ?>
				<?php echo $html->link(__('Delete', true), array('controller' => 'contact_activity_user_groups', 'action' => 'delete', $projectIssueUserGroup['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $projectIssueUserGroup['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $html->link(__('New Project Issue User Group', true), array('controller' => 'contact_activity_user_groups', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>

<div class="contactActivities view">
<h2><?php  __('ContactActivity');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $contactActivity['ContactActivity']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Contact Activity Parent'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($contactActivity['ContactActivityParent']['name'], array('controller' => 'contact_activities', 'action' => 'view', $contactActivity['ContactActivityParent']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Contact Activity Type'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($contactActivity['ContactActivityType']['name'], array('controller' => 'contact_activity_types', 'action' => 'view', $contactActivity['ContactActivityType']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $contactActivity['ContactActivity']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Description'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $contactActivity['ContactActivity']['description']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Contact'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($contactActivity['Contact']['id'], array('controller' => 'contacts', 'action' => 'view', $contactActivity['Contact']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Creator'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($contactActivity['Creator']['id'], array('controller' => 'users', 'action' => 'view', $contactActivity['Creator']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modifier Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $contactActivity['ContactActivity']['modifier_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $contactActivity['ContactActivity']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $contactActivity['ContactActivity']['modified']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit ContactActivity', true), array('action' => 'edit', $contactActivity['ContactActivity']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete ContactActivity', true), array('action' => 'delete', $contactActivity['ContactActivity']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $contactActivity['ContactActivity']['id'])); ?> </li>
		<li><?php echo $html->link(__('List ContactActivities', true), array('action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New ContactActivity', true), array('action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('List Contact Activities', true), array('controller' => 'contact_activities', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Contact Activity Parent', true), array('controller' => 'contact_activities', 'action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('List Contact Activity Types', true), array('controller' => 'contact_activity_types', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Contact Activity Type', true), array('controller' => 'contact_activity_types', 'action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Creator', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('List Contacts', true), array('controller' => 'contacts', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Contact', true), array('controller' => 'contacts', 'action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('List Contact Activity Media', true), array('controller' => 'contact_activity_media', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Contact Activity Medium', true), array('controller' => 'contact_activity_media', 'action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('List Contact Activity User Groups', true), array('controller' => 'contact_activity_user_groups', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Contact Activity User Group', true), array('controller' => 'contact_activity_user_groups', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Contact Activity Media');?></h3>
	<?php if (!empty($contactActivity['ContactActivityMedium'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Medium Id'); ?></th>
		<th><?php __('Contact Activity Id'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($contactActivity['ContactActivityMedium'] as $contactActivityMedium):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $contactActivityMedium['id'];?></td>
			<td><?php echo $contactActivityMedium['medium_id'];?></td>
			<td><?php echo $contactActivityMedium['contact_activity_id'];?></td>
			<td><?php echo $contactActivityMedium['created'];?></td>
			<td><?php echo $contactActivityMedium['modified'];?></td>
			<td class="actions">
				<?php echo $html->link(__('View', true), array('controller' => 'contact_activity_media', 'action' => 'view', $contactActivityMedium['id'])); ?>
				<?php echo $html->link(__('Edit', true), array('controller' => 'contact_activity_media', 'action' => 'edit', $contactActivityMedium['id'])); ?>
				<?php echo $html->link(__('Delete', true), array('controller' => 'contact_activity_media', 'action' => 'delete', $contactActivityMedium['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $contactActivityMedium['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $html->link(__('New Contact Activity Medium', true), array('controller' => 'contact_activity_media', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php __('Related Contact Activity User Groups');?></h3>
	<?php if (!empty($contactActivity['ContactActivityUserGroup'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('User Group Id'); ?></th>
		<th><?php __('Contact Activity Id'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($contactActivity['ContactActivityUserGroup'] as $contactActivityUserGroup):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $contactActivityUserGroup['id'];?></td>
			<td><?php echo $contactActivityUserGroup['user_group_id'];?></td>
			<td><?php echo $contactActivityUserGroup['contact_activity_id'];?></td>
			<td><?php echo $contactActivityUserGroup['created'];?></td>
			<td><?php echo $contactActivityUserGroup['modified'];?></td>
			<td class="actions">
				<?php echo $html->link(__('View', true), array('controller' => 'contact_activity_user_groups', 'action' => 'view', $contactActivityUserGroup['id'])); ?>
				<?php echo $html->link(__('Edit', true), array('controller' => 'contact_activity_user_groups', 'action' => 'edit', $contactActivityUserGroup['id'])); ?>
				<?php echo $html->link(__('Delete', true), array('controller' => 'contact_activity_user_groups', 'action' => 'delete', $contactActivityUserGroup['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $contactActivityUserGroup['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $html->link(__('New Contact Activity User Group', true), array('controller' => 'contact_activity_user_groups', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>

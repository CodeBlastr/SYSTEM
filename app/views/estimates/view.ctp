<div class="estimates view">
<h2><?php  __('Estimate');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $estimate['Estimate']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Estimate Type'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($estimate['EstimateType']['name'], array('controller' => 'enumerations', 'action' => 'view', $estimate['EstimateType']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Estimate Status'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($estimate['EstimateStatus']['name'], array('controller' => 'enumerations', 'action' => 'view', $estimate['EstimateStatus']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $estimate['Estimate']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Introduction'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $estimate['Estimate']['introduction']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Conclusion'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $estimate['Estimate']['conclusion']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Expiration Date'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $estimate['Estimate']['expiration_date']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Total'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $estimate['Estimate']['total']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Is Accepted'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $estimate['Estimate']['is_accepted']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Is Archived'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $estimate['Estimate']['is_archived']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Recipient'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($estimate['Recipient']['username'], array('controller' => 'users', 'action' => 'view', $estimate['Recipient']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Creator'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($estimate['Creator']['username'], array('controller' => 'users', 'action' => 'view', $estimate['Creator']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modifier'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($estimate['Modifier']['username'], array('controller' => 'users', 'action' => 'view', $estimate['Modifier']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $estimate['Estimate']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $estimate['Estimate']['modified']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Estimate', true), array('action' => 'edit', $estimate['Estimate']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Estimate', true), array('action' => 'delete', $estimate['Estimate']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $estimate['Estimate']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Estimates', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Estimate', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Enumerations', true), array('controller' => 'enumerations', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Estimate Type', true), array('controller' => 'enumerations', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Recipient', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Estimateds', true), array('controller' => 'estimateds', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Estimated', true), array('controller' => 'estimateds', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Estimateds');?></h3>
	<?php if (!empty($estimate['Estimated'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Estimate Id'); ?></th>
		<th><?php __('Foreign Key'); ?></th>
		<th><?php __('Model'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($estimate['Estimated'] as $estimated):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $estimated['id'];?></td>
			<td><?php echo $estimated['estimate_id'];?></td>
			<td><?php echo $estimated['foreign_key'];?></td>
			<td><?php echo $estimated['model'];?></td>
			<td><?php echo $estimated['created'];?></td>
			<td><?php echo $estimated['modified'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'estimateds', 'action' => 'view', $estimated['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'estimateds', 'action' => 'edit', $estimated['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'estimateds', 'action' => 'delete', $estimated['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $estimated['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Estimated', true), array('controller' => 'estimateds', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>

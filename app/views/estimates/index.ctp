<div class="estimates index">
	<h2><?php __('Estimates');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('estimate_type_id');?></th>
			<th><?php echo $this->Paginator->sort('estimate_status_id');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('introduction');?></th>
			<th><?php echo $this->Paginator->sort('conclusion');?></th>
			<th><?php echo $this->Paginator->sort('expiration_date');?></th>
			<th><?php echo $this->Paginator->sort('total');?></th>
			<th><?php echo $this->Paginator->sort('is_accepted');?></th>
			<th><?php echo $this->Paginator->sort('is_archived');?></th>
			<th><?php echo $this->Paginator->sort('recipient_id');?></th>
			<th><?php echo $this->Paginator->sort('creator_id');?></th>
			<th><?php echo $this->Paginator->sort('modifier_id');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($estimates as $estimate):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $estimate['Estimate']['id']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($estimate['EstimateType']['name'], array('controller' => 'enumerations', 'action' => 'view', $estimate['EstimateType']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($estimate['EstimateStatus']['name'], array('controller' => 'enumerations', 'action' => 'view', $estimate['EstimateStatus']['id'])); ?>
		</td>
		<td><?php echo $estimate['Estimate']['name']; ?>&nbsp;</td>
		<td><?php echo $estimate['Estimate']['introduction']; ?>&nbsp;</td>
		<td><?php echo $estimate['Estimate']['conclusion']; ?>&nbsp;</td>
		<td><?php echo $estimate['Estimate']['expiration_date']; ?>&nbsp;</td>
		<td><?php echo $estimate['Estimate']['total']; ?>&nbsp;</td>
		<td><?php echo $estimate['Estimate']['is_accepted']; ?>&nbsp;</td>
		<td><?php echo $estimate['Estimate']['is_archived']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($estimate['Recipient']['username'], array('controller' => 'users', 'action' => 'view', $estimate['Recipient']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($estimate['Creator']['username'], array('controller' => 'users', 'action' => 'view', $estimate['Creator']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($estimate['Modifier']['username'], array('controller' => 'users', 'action' => 'view', $estimate['Modifier']['id'])); ?>
		</td>
		<td><?php echo $estimate['Estimate']['created']; ?>&nbsp;</td>
		<td><?php echo $estimate['Estimate']['modified']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $estimate['Estimate']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $estimate['Estimate']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $estimate['Estimate']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $estimate['Estimate']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Estimate', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Enumerations', true), array('controller' => 'enumerations', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Estimate Type', true), array('controller' => 'enumerations', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Recipient', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Estimateds', true), array('controller' => 'estimateds', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Estimated', true), array('controller' => 'estimateds', 'action' => 'add')); ?> </li>
	</ul>
</div>
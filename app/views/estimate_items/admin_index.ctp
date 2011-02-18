<div class="estimateItems index">
	<h2><?php __('Estimate Items');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('estimate_id');?></th>
			<th><?php echo $this->Paginator->sort('estimate_item_type_id');?></th>
			<th><?php echo $this->Paginator->sort('foreign_key');?></th>
			<th><?php echo $this->Paginator->sort('model');?></th>
			<th><?php echo $this->Paginator->sort('notes');?></th>
			<th><?php echo $this->Paginator->sort('quantity');?></th>
			<th><?php echo $this->Paginator->sort('price');?></th>
			<th><?php echo $this->Paginator->sort('order');?></th>
			<th><?php echo $this->Paginator->sort('creator_id');?></th>
			<th><?php echo $this->Paginator->sort('modifier_id');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($estimateItems as $estimateItem):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $estimateItem['EstimateItem']['id']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($estimateItem['Estimate']['name'], array('controller' => 'estimates', 'action' => 'view', $estimateItem['Estimate']['id'])); ?>
		</td>
		<td><?php echo $estimateItem['EstimateItem']['estimate_item_type_id']; ?>&nbsp;</td>
		<td><?php echo $estimateItem['EstimateItem']['foreign_key']; ?>&nbsp;</td>
		<td><?php echo $estimateItem['EstimateItem']['model']; ?>&nbsp;</td>
		<td><?php echo $estimateItem['EstimateItem']['notes']; ?>&nbsp;</td>
		<td><?php echo $estimateItem['EstimateItem']['quantity']; ?>&nbsp;</td>
		<td><?php echo $estimateItem['EstimateItem']['price']; ?>&nbsp;</td>
		<td><?php echo $estimateItem['EstimateItem']['order']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($estimateItem['Creator']['username'], array('controller' => 'users', 'action' => 'view', $estimateItem['Creator']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($estimateItem['Modifier']['username'], array('controller' => 'users', 'action' => 'view', $estimateItem['Modifier']['id'])); ?>
		</td>
		<td><?php echo $estimateItem['EstimateItem']['created']; ?>&nbsp;</td>
		<td><?php echo $estimateItem['EstimateItem']['modified']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $estimateItem['EstimateItem']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $estimateItem['EstimateItem']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $estimateItem['EstimateItem']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $estimateItem['EstimateItem']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Estimate Item', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Estimates', true), array('controller' => 'estimates', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Estimate', true), array('controller' => 'estimates', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Creator', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
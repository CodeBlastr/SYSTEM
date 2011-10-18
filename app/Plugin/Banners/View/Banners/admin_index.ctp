<div class="banners index">
	<h2><?php __('Banners');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('description');?></th>
			<th><?php echo $this->Paginator->sort('banner_position_id');?></th>
			<th><?php echo $this->Paginator->sort('schedule_start_date');?></th>
			<th><?php echo $this->Paginator->sort('schedule_end_date');?></th>
			<th><?php echo $this->Paginator->sort('type');?></th>
			<th><?php echo $this->Paginator->sort('gender');?></th>
			<th><?php echo $this->Paginator->sort('age_group');?></th>
			<th><?php echo $this->Paginator->sort('price');?></th>
			<th><?php echo $this->Paginator->sort('customer_id');?></th>
			<th><?php echo $this->Paginator->sort('redemption_url');?></th>
			<th><?php echo $this->Paginator->sort('discount_price');?></th>
			<th><?php echo $this->Paginator->sort('discount_percentage');?></th>
			<th><?php echo $this->Paginator->sort('is_published');?></th>
			<th><?php echo $this->Paginator->sort('creator_id');?></th>
			<th><?php echo $this->Paginator->sort('modifier_id');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($banners as $banner):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $banner['Banner']['id']; ?>&nbsp;</td>
		<td><?php echo $banner['Banner']['name']; ?>&nbsp;</td>
		<td><?php echo $banner['Banner']['description']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($banner['BannerPosition']['name'], array('controller' => 'banner_positions', 'action' => 'view', $banner['BannerPosition']['id'])); ?>
		</td>
		<td><?php echo $banner['Banner']['schedule_start_date']; ?>&nbsp;</td>
		<td><?php echo $banner['Banner']['schedule_end_date']; ?>&nbsp;</td>
		<td><?php echo $banner['Banner']['type']; ?>&nbsp;</td>
		<td><?php echo $banner['Banner']['gender']; ?>&nbsp;</td>
		<td><?php echo $banner['Banner']['age_group']; ?>&nbsp;</td>
		<td><?php echo $banner['Banner']['price']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($banner['Customer']['username'], array('controller' => 'customers', 'action' => 'view', $banner['Customer']['id'])); ?>
		</td>
		<td><?php echo $banner['Banner']['redemption_url']; ?>&nbsp;</td>
		<td><?php echo $banner['Banner']['discount_price']; ?>&nbsp;</td>
		<td><?php echo $banner['Banner']['discount_percentage']; ?>&nbsp;</td>
		<td><?php echo $banner['Banner']['is_published']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($banner['Creator']['username'], array('controller' => 'creators', 'action' => 'view', $banner['Creator']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($banner['Modifier']['username'], array('controller' => 'modifiers', 'action' => 'view', $banner['Modifier']['id'])); ?>
		</td>
		<td><?php echo $banner['Banner']['created']; ?>&nbsp;</td>
		<td><?php echo $banner['Banner']['modified']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $banner['Banner']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $banner['Banner']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $banner['Banner']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $banner['Banner']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Banner', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Banner Positions', true), array('controller' => 'banner_positions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Banner Position', true), array('controller' => 'banner_positions', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Customers', true), array('controller' => 'customers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Customer', true), array('controller' => 'customers', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Creators', true), array('controller' => 'creators', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Creator', true), array('controller' => 'creators', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Modifiers', true), array('controller' => 'modifiers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Modifier', true), array('controller' => 'modifiers', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Order Items', true), array('controller' => 'order_items', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Order Item', true), array('controller' => 'order_items', 'action' => 'add')); ?> </li>
	</ul>
</div>
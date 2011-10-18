<div class="bannerPositions index">
	<h2><?php __('Banner Positions');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('description');?></th>
			<th><?php echo $this->Paginator->sort('price');?></th>
			<th><?php echo $this->Paginator->sort('creator_id');?></th>
			<th><?php echo $this->Paginator->sort('modifier_id');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($bannerPositions as $bannerPosition):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $bannerPosition['BannerPosition']['id']; ?>&nbsp;</td>
		<td><?php echo $bannerPosition['BannerPosition']['name']; ?>&nbsp;</td>
		<td><?php echo $bannerPosition['BannerPosition']['description']; ?>&nbsp;</td>
		<td><?php echo $bannerPosition['BannerPosition']['price']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($bannerPosition['Creator']['username'], array('controller' => 'users', 'action' => 'view', $bannerPosition['Creator']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($bannerPosition['Modifier']['username'], array('controller' => 'users', 'action' => 'view', $bannerPosition['Modifier']['id'])); ?>
		</td>
		<td><?php echo $bannerPosition['BannerPosition']['created']; ?>&nbsp;</td>
		<td><?php echo $bannerPosition['BannerPosition']['modified']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $bannerPosition['BannerPosition']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $bannerPosition['BannerPosition']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $bannerPosition['BannerPosition']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $bannerPosition['BannerPosition']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Banner Position', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Banners', true), array('controller' => 'banners', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Banner', true), array('controller' => 'banners', 'action' => 'add')); ?> </li>
	</ul>
</div>
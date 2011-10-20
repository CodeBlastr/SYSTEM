<div class="bannerViews index">
	<h2><?php echo __('Banner Views');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('banner_id');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($bannerViews as $bannerView):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $bannerView['BannerView']['id']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($bannerView['Banner']['name'], array('controller' => 'banners', 'action' => 'view', $bannerView['Banner']['id'])); ?>
		</td>
		<td><?php echo $bannerView['BannerView']['created']; ?>&nbsp;</td>
		<td><?php echo $bannerView['BannerView']['modified']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $bannerView['BannerView']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $bannerView['BannerView']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $bannerView['BannerView']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $bannerView['BannerView']['id'])); ?>
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
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Banner View', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Banners', true), array('controller' => 'banners', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Banner', true), array('controller' => 'banners', 'action' => 'add')); ?> </li>
	</ul>
</div>
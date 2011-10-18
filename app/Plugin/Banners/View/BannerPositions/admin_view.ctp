<div class="bannerPositions view">
<h2><?php  __('Banner Position');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $bannerPosition['BannerPosition']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $bannerPosition['BannerPosition']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Description'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $bannerPosition['BannerPosition']['description']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Price'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $bannerPosition['BannerPosition']['price']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $bannerPosition['BannerPosition']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $bannerPosition['BannerPosition']['modified']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Banner Position', true), array('action' => 'edit', $bannerPosition['BannerPosition']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Banner Position', true), array('action' => 'delete', $bannerPosition['BannerPosition']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $bannerPosition['BannerPosition']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Banner Positions', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Banner Position', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Creator', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Banners', true), array('controller' => 'banners', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Banner', true), array('controller' => 'banners', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Banners');?></h3>
	<?php if (!empty($bannerPosition['Banner'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Description'); ?></th>
		<th><?php echo __('Banner Position Id'); ?></th>
		<th><?php echo __('Schedule Start Date'); ?></th>
		<th><?php echo __('Schedule End Date'); ?></th>
		<th><?php echo __('Price'); ?></th>
		<th><?php echo __('Customer Id'); ?></th>
		<th><?php echo __('Redumption Url'); ?></th>
		<th><?php echo __('Discount Price'); ?></th>
		<th><?php echo __('Discount Percentage'); ?></th>
		<th><?php echo __('Is Published'); ?></th>
		<th><?php echo __('Creator Id'); ?></th>
		<th><?php echo __('Modifier Id'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($bannerPosition['Banner'] as $banner):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $banner['id'];?></td>
			<td><?php echo $banner['name'];?></td>
			<td><?php echo $banner['description'];?></td>
			<td><?php echo $banner['banner_position_id'];?></td>
			<td><?php echo $banner['schedule_start_date'];?></td>
			<td><?php echo $banner['schedule_end_date'];?></td>
			<td><?php echo $banner['price'];?></td>
			<td><?php echo $banner['customer_id'];?></td>
			<td><?php echo $banner['redemption_url'];?></td>
			<td><?php echo $banner['discount_price'];?></td>
			<td><?php echo $banner['discount_percentage'];?></td>
			<td><?php echo $banner['is_published'];?></td>
			<td><?php echo $banner['creator_id'];?></td>
			<td><?php echo $banner['modifier_id'];?></td>
			<td><?php echo $banner['created'];?></td>
			<td><?php echo $banner['modified'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'banners', 'action' => 'view', $banner['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'banners', 'action' => 'edit', $banner['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'banners', 'action' => 'delete', $banner['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $banner['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Banner', true), array('controller' => 'banners', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>

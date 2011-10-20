<div class="bannerViews view">
<h2><?php  __('Banner View');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $bannerView['BannerView']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Banner'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($bannerView['Banner']['name'], array('controller' => 'banners', 'action' => 'view', $bannerView['Banner']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $bannerView['BannerView']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $bannerView['BannerView']['modified']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Banner View', true), array('action' => 'edit', $bannerView['BannerView']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Banner View', true), array('action' => 'delete', $bannerView['BannerView']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $bannerView['BannerView']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Banner Views', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Banner View', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Banners', true), array('controller' => 'banners', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Banner', true), array('controller' => 'banners', 'action' => 'add')); ?> </li>
	</ul>
</div>

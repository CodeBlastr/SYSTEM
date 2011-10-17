<div class="bannerViews form">
<?php echo $this->Form->create('BannerView');?>
	<fieldset>
 		<legend><?php __('Admin Edit Banner View'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('banner_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('BannerView.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('BannerView.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Banner Views', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Banners', true), array('controller' => 'banners', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Banner', true), array('controller' => 'banners', 'action' => 'add')); ?> </li>
	</ul>
</div>
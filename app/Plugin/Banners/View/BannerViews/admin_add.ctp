<div class="bannerViews form">
<?php echo $this->Form->create('BannerView');?>
	<fieldset>
 		<legend><?php echo __('Admin Add Banner View'); ?></legend>
	<?php
		echo $this->Form->input('banner_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Banner Views', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Banners', true), array('controller' => 'banners', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Banner', true), array('controller' => 'banners', 'action' => 'add')); ?> </li>
	</ul>
</div>
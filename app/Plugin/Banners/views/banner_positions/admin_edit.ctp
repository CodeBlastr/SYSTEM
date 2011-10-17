<div class="bannerPositions form">
<?php echo $this->Form->create('BannerPosition');?>
	<fieldset>
 		<legend><?php __('Admin Edit Banner Position'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('banner_type_id');
		echo $this->Form->input('name');
		echo $this->Form->input('description');
		echo $this->Form->input('price');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('BannerPosition.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('BannerPosition.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Banner Positions', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Creator', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Banners', true), array('controller' => 'banners', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Banner', true), array('controller' => 'banners', 'action' => 'add')); ?> </li>
	</ul>
</div>
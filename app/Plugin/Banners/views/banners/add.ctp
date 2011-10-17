<div class="banners form">
<?php echo $this->Form->create('Banner');?>
	<fieldset>
 		<legend><?php __('Add Banner'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('description');
		echo $this->Form->input('banner_position_id');
		echo $this->Form->input('schedule_start_date');
		echo $this->Form->input('schedule_end_date');
		echo $this->Form->input('type');
		echo $this->Form->input('gender');
		echo $this->Form->input('age_group');
		echo $this->Form->input('price');
		echo $this->Form->input('customer_id');
		echo $this->Form->input('redemption_url');
		echo $this->Form->input('discount_price');
		echo $this->Form->input('discount_percentage');
		echo $this->Form->input('is_published');
		echo $this->Form->input('creator_id');
		echo $this->Form->input('modifier_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Banners', true), array('action' => 'index'));?></li>
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
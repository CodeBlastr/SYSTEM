<div class="estimateItems form">
<?php echo $this->Form->create('EstimateItem');?>
	<fieldset>
 		<legend><?php __('Add Estimate Item'); ?></legend>
	<?php
		echo $this->Form->input('estimate_id');
		echo $this->Form->input('estimate_item_type_id');
		echo $this->Form->input('foreign_key');
		echo $this->Form->input('model');
		echo $this->Form->input('notes');
		echo $this->Form->input('quantity');
		echo $this->Form->input('price');
		echo $this->Form->input('order');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Estimate Items', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Estimates', true), array('controller' => 'estimates', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Estimate', true), array('controller' => 'estimates', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Creator', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
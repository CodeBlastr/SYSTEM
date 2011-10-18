<div class="aros form">
<?php echo $this->Form->create('Requestor');?>
	<fieldset>
 		<legend><?php echo __('Edit Requestor');?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('parent_id');
		echo $this->Form->input('model');
		echo $this->Form->input('foreign_key');
		echo $this->Form->input('alias');
		echo $this->Form->input('Section');
	?>
	</fieldset>
<?php echo $this->Form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Requestor.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Requestor.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Requestors', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Acos', true), array('controller' => 'sections', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Aco', true), array('controller' => 'sections', 'action' => 'add')); ?> </li>
	</ul>
</div>

<div class="aros form">
<?php echo $form->create('Requestor');?>
	<fieldset>
 		<legend><?php __('Edit Requestor');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('parent_id');
		echo $form->input('model');
		echo $form->input('foreign_key');
		echo $form->input('alias');
		echo $form->input('Section');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $form->value('Requestor.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Requestor.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Requestors', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Acos', true), array('controller' => 'sections', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Aco', true), array('controller' => 'sections', 'action' => 'add')); ?> </li>
	</ul>
</div>

<div class="estimates form">
<?php echo $this->Form->create('Estimate');?>
	<fieldset>
 		<legend><?php __('Add Estimate'); ?></legend>
	<?php
		echo $this->Form->input('Estimate.recipient_id');
		echo $this->Form->input('Estimate.estimate_number');
		echo $this->Form->input('Estimate.issue_date');
		echo $this->Form->input('Estimate.expiration_date');
		echo $this->Form->input('Estimate.po_number');
		#echo $this->Form->input('Estimate.estimate_type_id');
		#echo $this->Form->input('Estimate.estimate_status_id');
		echo $this->Form->input('Estimate.introduction' /*, array('type' => 'richtext', 'ckeSettings' => array('buttons' => array('Bold','Italic','Underline','FontSize','TextColor','BGColor','-','NumberedList','BulletedList','Blockquote','JustifyLeft','JustifyCenter','JustifyRight','-','Link','Unlink','-', 'Image'))) */);
		echo $this->Form->input('Estimate.conclusion' /*, array('type' => 'richtext', 'ckeSettings' => array('buttons' => array('Bold','Italic','Underline','FontSize','TextColor','BGColor','-','NumberedList','BulletedList','Blockquote','JustifyLeft','JustifyCenter','JustifyRight','-','Link','Unlink','-', 'Image')))*/);
		echo $this->Form->input('Estimate.discount', array('after' => '%'));
		echo $this->Form->input('Estimate.sub_total');
		echo $this->Form->input('Estimate.total');
		#echo $this->Form->input('Estimate.is_accepted');
		#echo $this->Form->input('Estimate.is_archived');
	?>
	</fieldset>
    
	<fieldset>
 		<legend><?php __('Add Estimate Item'); ?></legend>
	<?php
		echo $this->Form->input('EstimateItem.estimate_item_type_id');
		echo $this->Form->input('EstimateItem.foreign_key');
		echo $this->Form->input('EstimateItem.model');
		echo $this->Form->input('EstimateItem.notes');
		echo $this->Form->input('EstimateItem.quantity');
		echo $this->Form->input('EstimateItem.price');
		echo $this->Form->input('EstimateItem.order');
	?>
	</fieldset>
	<fieldset>
 		<legend><?php __('Cost'); ?></legend>
	<?php
		echo $this->Form->input('Estimate.discount', array('after' => '%'));
		echo $this->Form->input('Estimate.sub_total');
		echo $this->Form->input('Estimate.total');
	?>
	</fieldset>
    
    
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Estimates', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Enumerations', true), array('controller' => 'enumerations', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Estimate Type', true), array('controller' => 'enumerations', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Recipient', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Estimateds', true), array('controller' => 'estimateds', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Estimated', true), array('controller' => 'estimateds', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="userGroups form">
<?php echo $this->Form->create('UserGroup');?>
	<fieldset>
 		<legend><?php echo __('Admin Edit User Group'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('title');
		echo $this->Form->input('description');
		echo $this->Form->input('creator_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('UserGroup.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('UserGroup.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List User Groups', true), array('action' => 'index'));?></li>
	</ul>
</div>
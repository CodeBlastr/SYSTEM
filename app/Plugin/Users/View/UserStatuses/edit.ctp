<div class="userStatuses form">
<?php echo $this->Form->create('UserStatus');?>
	<fieldset>
 		<legend><?php echo __('Edit User Status'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('status');
		echo $this->Form->input('creator_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<?php 
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'User Statuses',
		'items' => array(
			$this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('UserStatus.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('UserStatus.id'))),
			$this->Html->link(__('List User Statuses', true), array('action' => 'index')),
			)
		),
	)));
?>
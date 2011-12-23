<div class="userGroupWallPosts form">
<?php echo $this->Form->create('UserGroupWallPost');?>
	<fieldset>
 		<legend><?php echo __('Edit User Group Wall Post'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('post');
		echo $this->Form->input('user_group_id');
		echo $this->Form->input('creator');
		echo $this->Form->input('modifier');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<?php 
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'User Groups',
		'items' => array(
			$this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('UserGroupWallPost.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('UserGroupWallPost.id'))),
			$this->Html->link(__('List User Group Wall Posts', true), array('action' => 'index')),
			$this->Html->link(__('List User Groups', true), array('controller' => 'user_groups', 'action' => 'index')),
			$this->Html->link(__('New User Group', true), array('controller' => 'user_groups', 'action' => 'add')),
			)
		),
	)));
?>
<div class="userfollowers form">
<?php echo $this->Form->create('Userfollower');?>
	<fieldset>
 		<legend><?php echo __('Edit User follower'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('user_id');
		echo $this->Form->input('follower_id');
		echo $this->Form->input('approved');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<?php 
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'User Followers',
		'items' => array(
			$this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Userfollower.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Userfollower.id'))),
			$this->Html->link(__('List User Followers', true), array('action' => 'index')),
			$this->Html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')),
			$this->Html->link(__('New User', true), array('controller' => 'users', 'action' => 'add')),
			)
		),
	)));
?>
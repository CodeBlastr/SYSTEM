<div class="userWalls form">
<?php echo $this->Form->create('UserWall');?>
	<fieldset>
 		<legend><?php echo __('Edit User Wall'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('post');
		echo $this->Form->input('creator_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<?php 
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'User Walls',
		'items' => array(
			$this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('UserWall.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('UserWall.id'))),
			$this->Html->link(__('List User Walls', true), array('action' => 'index')),
			)
		),
	)));
?>
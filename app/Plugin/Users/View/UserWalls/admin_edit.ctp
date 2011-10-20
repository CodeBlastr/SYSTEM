<div class="userWalls form">
<?php echo $this->Form->create('UserWall');?>
	<fieldset>
 		<legend><?php echo __('Admin Edit User Wall'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('post');
		echo $this->Form->input('creator_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('UserWall.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('UserWall.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List User Walls', true), array('action' => 'index'));?></li>
	</ul>
</div>
<div class="userWalls form">
<?php echo $this->Form->create('UserWall');?>
	<fieldset>
 		<legend><?php __('Admin Add User Wall'); ?></legend>
	<?php
		echo $this->Form->input('post');
		echo $this->Form->input('creator_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List User Walls', true), array('action' => 'index'));?></li>
	</ul>
</div>
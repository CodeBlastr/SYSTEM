<div class="userfollowers form">
<?php echo $this->Form->create('Userfollower');?>
	<fieldset>
 		<legend><?php __('Admin Add User follower'); ?></legend>
	<?php
		echo $this->Form->input('user_id');
		echo $this->Form->input('follower_id');
		echo $this->Form->input('approved');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List User followers', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>

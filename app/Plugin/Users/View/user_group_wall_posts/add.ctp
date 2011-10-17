<div class="userGroupWallPosts form">
<?php echo $this->Form->create('UserGroupWallPost' , array('url'=>array('plugin'=>'users','controller'=>'user_group_wall_posts' , 'action'=>'add', $this->params["pass"][0] )));?>
	<fieldset>
 		<legend><?php __('Add User Group Wall Post'); ?></legend>
	<?php
		echo $this->Form->input('post');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>

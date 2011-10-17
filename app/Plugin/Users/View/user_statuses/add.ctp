<div class="userStatuses form">
<?php echo $this->Form->create('UserStatus');?>
	<fieldset>
 		<legend><?php __('Add User Status'); ?></legend>
	<?php
		echo $this->Form->input('status' , array('type'=>'textfield' , 'label'=>'Update Your Status'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
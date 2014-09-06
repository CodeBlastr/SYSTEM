<div id="users-edit" class="users edit form">
  <fieldset>
    <legend><h2><?php echo __('Change %s\'s Password', $this->request->data['User']['full_name']); ?></h2></legend>
<?php 
	echo $this->Form->create('User', array('enctype'=>'multipart/form-data'));
	echo $this->Form->input('User.id', array('type' => 'hidden'));
	echo $this->Form->input('User.username', array('type' => 'hidden'));
	echo $this->Form->input('User.user_role_id', array('type' => 'hidden'));
	echo $this->Form->input('User.password', array('value' => '', 'after' => '<small>Please enter at least six characters, with capital, lowercase, and numeric characters.</small>', 'pattern' => '^((?=.*[^a-zA-Z])(?=.*[a-z])(?=.*[A-Z])(?!.*\s).{6,})$', 'title' => 'Please enter at least six characters, with capital, lowercase, and numeric characters.'));
	echo $this->Form->input('User.confirm_password', array('value' => '', 'type' => 'password'));
	echo $this->Form->end('Change');
?>
  </fieldset>
</div>
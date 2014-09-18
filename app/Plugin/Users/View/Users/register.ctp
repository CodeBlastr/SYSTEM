<div id="userRegister" class="user form">
	<?php echo $this->Form->create('User', array('type' => 'file')); ?>
	<?php echo $this->Form->input('Contact.id', array('type' => 'hidden')); ?>  
	<fieldset>
		<?php echo $this->Form->input('User.contact_type', array('type' => 'hidden')); ?>
		<?php echo $this->Form->input('User.referal_code', array('type' => 'hidden')); ?>
		<?php echo !empty($this->request->data['User']['user_role_id']) ? $this->Form->hidden('User.user_role_id') : $this->Form->input('User.user_role_id'); ?>
		<?php echo $this->Form->input('User.full_name', array('label' => 'Name')); ?>
		<?php echo $this->Form->input('User.username', array('label' => 'Email')); ?>
		<?php echo $this->Form->input('User.password', array('value' => '', 'after' => '<small>Please enter at least six characters, with capital, lowercase, and numeric characters.</small>', 'pattern' => '^((?=.*[^a-zA-Z])(?=.*[a-z])(?=.*[A-Z])(?!.*\s).{6,})$', 'title' => 'Please enter at least six characters, with capital, lowercase, and numeric characters.')); ?>
	</fieldset>
	<?php echo $this->Form->end('Submit'); ?>
</div>
<?php
// set the contextual menu items
$this->set('context_menu', array('menus' => array( array(
			'heading' => 'Users',
			'items' => array(
				$this->Html->link(__('Login'), array(
					'plugin' => 'users',
					'controller' => 'users',
					'action' => 'login'
				)),
				$this->Html->link(__('Logout'), array(
					'plugin' => 'users',
					'controller' => 'users',
					'action' => 'logout'
				)),
			)
		))));

<div id="userRegister" class="user form">
	<?php echo $this->Form->create('User', array('type' => 'file')); ?>
	<?php echo $this->Form->input('Contact.id', array('type' => 'hidden')); ?>  
	<fieldset>
		<?php echo $this->Form->input('User.contact_type', array('type' => 'hidden')); ?>
		<?php echo $this->Form->input('User.referal_code', array('type' => 'hidden')); ?>
		<?php echo !empty($userRoleId) ? $this->Form->hidden('User.user_role_id', array('value' => $userRoleId)) : $this->Form->input('User.user_role_id'); ?>
		<?php echo $this->Form->input('User.full_name', array('label' => 'Name')); ?>
		<?php echo $this->Form->input('User.username', array('label' => 'Email')); ?>
		<?php echo $this->Form->input('User.password', array('value' => '')); ?>
		<?php echo $this->Form->input('User.confirm_password', array('type' => 'password', 'value' => '')); ?>
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

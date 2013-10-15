<div id="user-add" class="users form">
    
<?php echo $this->Form->create(array('plugin' => 'users', 'controller' => 'user_groups', 'action' => 'user', $userGroup['UserGroup']['id']));?>
	<fieldset>
 		<legend><?php echo __('Create User in %s', $userGroup['UserGroup']['title']);?></legend>
		<?php
		echo $this->Form->input('UserGroup.UserGroup.0', array('type' => 'hidden'));
		echo $this->Form->input('User.first_name');
		echo $this->Form->input('User.last_name');
		echo $this->Form->input('User.username', array('label' => 'Email'));
		//echo $this->Form->input('User.password');
		echo $this->Form->input('User.user_role_id');
		?>
	</fieldset>
<?php echo $this->Form->end('Submit');?>
</div>

<?php 
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Users',
		'items' => array(
			$this->Html->link(__('Login', true), array('plugin' => 'users', 'controller' => 'users', 'action' => 'login', 'admin' => 0)),
			 )
		),
	))); ?>
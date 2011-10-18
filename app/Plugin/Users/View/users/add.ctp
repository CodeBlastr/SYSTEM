<div id="user-add" class="users form">
    
<?php echo $this->Form->create('User');?>
	<fieldset>
 		<legend><?php __('Add User');?></legend>
	<?php
		echo $this->Form->input('username');
		echo $this->Form->input('password');
		echo $this->Form->input('user_role_id');
	?>
	</fieldset>
<?php echo $this->Form->end('Submit');?>
</div>

<?php 
// set the contextual menu items
echo $this->Element('context_menu', array('menus' => array(
	array(
		'heading' => 'Users',
		'items' => array(
			$this->Html->link(__('Login', true), array('plugin' => 'users', 'controller' => 'users', 'action' => 'login', 'admin' => 0)),
			 )
		),
	)));
?>
<div class="userRoles form row-fluid">
	
	<?php
	echo $this->Form->create('UserRole');
	echo __('<p class="span4 pull-right well">%s</p>', 'User roles allow you to group users for the purpose of granting permissions for many users at once.');
	echo !empty($this->request->data['UserRole']['duplicate']) ? __('<p class="span4 pull-right well">%s</p>', 'Duplicating user roles carries permissions from the old user role to the new user role.') : null;
	echo '<fieldset>';
	echo $this->Form->input('UserRole.name');
	echo $this->Form->input('UserRole.duplicate', array('type' => 'hidden'));
	echo $this->Form->input('UserRole.view_prefix', array('empty' => '-- Option View Access --'));
	echo '</fieldset>';
	echo $this->Form->end('Submit'); ?>

</div>

<?php
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'User Roles',
		'items' => array(
			 $this->Html->link(__('List', true), array('action' => 'index')),
			 )
		),
	array(
		'heading' => 'Users',
		'items' => array(
			 $this->Html->link(__('Users', true), array('controller' => 'users', 'action' => 'index')),
			 )
		),
	))); ?>
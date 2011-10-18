<div class="userRoles form">
<?php echo $this->Form->create('UserRole');?>
	<fieldset>
 		<legend><?php __('Add UserRole');?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('view_prefix', array('empty' => '-- Option View Access --'));
	?>
	</fieldset>
<?php echo $this->Form->end('Submit');?>
</div>
<?php 
// set the contextual menu items
echo $this->Element('context_menu', array('menus' => array(
	array(
		'heading' => 'User Roles',
		'items' => array(
			 $this->Html->link(__('List User Roles', true), array('action' => 'index')),
			 )
		),
	array(
		'heading' => 'Users',
		'items' => array(
			 $this->Html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')),
			 )
		),
	)));
?>

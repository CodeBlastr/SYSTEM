<div class="userRoles form">
<?php echo $form->create('UserRole');?>
	<fieldset>
 		<legend><?php __('Edit UserRole');?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('view_prefix', array('empty' => '-- Option View Access --'));
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>

<?php 
// set the contextual menu items
$menu->setValue(array(
	array(
		'heading' => 'User Roles',
		'items' => array(
			 $this->Html->link(__('Delete', true), array('action' => 'delete', $form->value('UserRole.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('UserRole.id'))),
			 $this->Html->link(__('List UserRoles', true), array('action' => 'index')),
			 )
		),
	array(
		'heading' => 'Users',
		'items' => array(
			 $this->Html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')),
			 )
		),
	));
?>

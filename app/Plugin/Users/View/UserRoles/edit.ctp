<div class="userRoles form">
<?php echo $this->Form->create('UserRole');?>
	<fieldset>
 		<legend><?php __('Edit UserRole');?></legend>
	<?php
		echo $this->Form->input('id');
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
			 $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('UserRole.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('UserRole.id'))),
			 $this->Html->link(__('List UserRoles', true), array('action' => 'index')),
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

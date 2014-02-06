<div class="userRoles form">
<?php echo $this->Form->create('UserRole');?>
	<fieldset>
 		<legend><?php echo __('Edit User Role');?></legend>
	<?php echo $this->Form->input('UserRole.id'); ?>
	<?php echo $this->Form->input('UserRole.name'); ?>
    <?php echo $this->Form->input('UserRole.is_registerable'); ?>
	<?php echo $this->Form->input('UserRole.view_prefix', array('empty' => '-- Option View Access --')); ?>
	</fieldset>
<?php echo $this->Form->end('Submit');?>
</div>

<?php 
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
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

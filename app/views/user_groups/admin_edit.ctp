<div class="userGroups form">
<?php echo $form->create('UserGroup');?>
	<fieldset>
 		<legend><?php __('Edit UserGroup');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('name');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>

<?php 
// set the contextual menu items
$menu->setValue(array(
	array(
		'heading' => 'User Groups',
		'items' => array(
			 $html->link(__('Delete', true), array('action' => 'delete', $form->value('UserGroup.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('UserGroup.id'))),
			 $html->link(__('List UserGroups', true), array('action' => 'index')),
			 )
		),
	array(
		'heading' => 'Users',
		'items' => array(
			 $html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')),
			 )
		),
	));
?>

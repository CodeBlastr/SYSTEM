<div class="userGroups form">
<?php echo $form->create('UserGroup');?>
	<fieldset>
 		<legend><?php __('Add UserGroup');?></legend>
	<?php
		echo $form->input('parent_id', array('empty' => '--None--'));
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
			 $html->link(__('List User Groups', true), array('action' => 'index')),
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

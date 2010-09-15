<div class="conditions form">
<?php echo $form->create('Condition', array('action' => 'edit'));?>
	<fieldset>
 		<legend><?php __('Edit Condition');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('name');
		echo $form->input('plugin');
		echo $form->input('controller');
		echo $form->input('action');
		echo $form->input('condition');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>

<?php 
// set the contextual menu items
$menu->setValue(array(
	array(
		'heading' => 'Conditions',
		'items' => array(
			$html->link(__('List Conditions', true), array('plugin' => null, 'controller' => 'conditions', 'action' => 'index')),
			)
		),
	)
);
?>

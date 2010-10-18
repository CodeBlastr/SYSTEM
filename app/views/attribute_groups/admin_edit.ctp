<div class="attributes form">
<?php echo $form->create('AttributeGroup', array('action' => 'edit'));?>
	<fieldset>
 		<legend><?php __('Edit Attribute');?></legend>
	<?php
		echo $form->input('AttributeGroup.id');
		echo $form->input('AttributeGroup.enumeration_id'); 
		echo $form->input('AttributeGroup.name'); 
		echo $form->input('AttributeGroup.model', array('after' => ' (model alias of the db table attributes will be written to)' )); 
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<?php 
// set the contextual menu items
$menu->setValue(array(
	array(
		'heading' => 'Attribute Groups',
		'items' => array(
			$html->link(__('Delete', true), array('action' => 'delete', $form->value('AttributeGroup.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('AttributeGroup.id'))),
			$html->link(__('List Attributes', true), array('action' => 'index')),
			)
		),
	array(
		'heading' => 'Attributes',
		'items' => array(
			$html->link(__('New Attributes', true), array('controller' => 'attributes', 'action' => 'edit')),
			$html->link(__('List Attributess', true), array('controller' => 'attributes', 'action' => 'index')),
			)
		),
	)
);
?>

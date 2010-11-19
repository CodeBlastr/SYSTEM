<div class="attributes form">
<h1><?php __('Create a Form Fieldset');?></h1>
<?php echo $form->create('AttributeGroup', array('action' => 'edit'));?>
	<fieldset>
 		<legend><?php __('Edit Attribute');?></legend>
	<?php
		echo $form->input('AttributeGroup.id');
		echo $form->input('AttributeGroup.name'); 
		echo $form->input('AttributeGroup.display_name', array('after' => ' Leave empty to remove legend tag')); 
	?>
    </fieldset>
    <fieldset>
    	<legend><?php __('Display Conditions');?></legend>
     <?php
		echo $form->input('AttributeGroup.enumeration_id', array(
					'label' => 'Group groups', 
					'empty' => '-- Select Limiter --'
					)); 
		echo $form->input('AttributeGroup.plugin'); 
		echo $form->input('AttributeGroup.model', array('after' => ' (model alias of the db table attributes will be written to)' )); 
		echo $form->input('AttributeGroup.order'); 
		echo $form->input('AttributeGroup.is_system'); 
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

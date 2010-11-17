<div class="attributes form">
<?php echo $form->create('Attribute');?>
	<fieldset>
 		<legend><?php __('Edit Attribute');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('attribute_group_id'); 
		echo $form->input('code', array('after' => ' (action database column name)')); 
		echo $form->input('name'); 
		echo $form->input('input_type_id', array('type' => 'select', 'options' => array('Text Field', 'Text Area'/*, 'Date', 'Yes/No', 'Multiple Select', 'Dropdown', 'Media/Image/File'*/))); 
		echo $form->input('default_value'); 
		echo $form->input('is_system'); 
		echo $form->input('is_unique'); 
		echo $form->input('is_required'); 
		echo $form->input('is_quicksearch'); 
		echo $form->input('is_advancedsearch'); 
		echo $form->input('is_comparable'); 
		echo $form->input('is_layered'); 
		echo $form->input('layer_order'); 
		echo $form->input('is_visible'); 
		echo $form->input('is_addable'); 
		echo $form->input('is_editable'); 
		echo $form->input('order'); 
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<?php 
// set the contextual menu items
$menu->setValue(array(
	array(
		'heading' => 'Attributes',
		'items' => array(
			$html->link(__('Delete', true), array('action' => 'delete', $form->value('Attribute.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Attribute.id'))),
			$html->link(__('List Attributes', true), array('action' => 'index')),
			)
		),
	array(
		'heading' => 'Attribute Groups',
		'items' => array(
			$html->link(__('New AttributeGroup', true), array('controller' => 'attribute_groups', 'action' => 'edit')),
			$html->link(__('List AttributeGroups', true), array('controller' => 'attribute_groups', 'action' => 'index')),
			)
		),
	)
);
?>

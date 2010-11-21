<div class="conditions form">
<?php echo $form->create('Condition', array('action' => 'edit'));?>
	<fieldset>
 		<legend><?php __('Edit Condition');?></legend>
	<?php
		echo $form->input('Condition.id');
		echo $form->input('Condition.name');
		echo $form->input('Condition.description');
		echo $form->input('Condition.plugin', array('after' => ' Plugin called to match against.'));
		echo $form->input('Condition.controller', array('after' => ' Controller name to match.'));
		echo $form->input('Condition.action', array('after' => ' Controller method to match.'));
		echo $form->input('Condition.condition', array('after' => ' Sub-conditions to match against. Model.field.operator.value,Model.field.operator.value'));
		echo $form->input('Condition.model', array('after' => ' The bind model calling this condition. Currently the only model supported is Workflows.Workflow', 'default' => 'Workflows.Workflow'));
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

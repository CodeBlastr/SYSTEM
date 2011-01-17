<h1>Manage Condtion</h1>
<div class="conditions form">
<?php echo $form->create('Condition', array('action' => 'edit'));?>
	<fieldset>
 		<legend><?php __('Internal Condition Description');?></legend>
	<?php
		echo $form->input('Condition.id');
		echo $form->input('Condition.name');
		echo $form->input('Condition.description');
	?>
    </fieldset>
    <fieldset>
 		<legend><?php __('When This Condition is Triggered');?></legend>
   	<?php
		echo $form->input('Condition.is_create', array('label' => 'Fire when record is created.'));
		echo $form->input('Condition.is_read', array('label' => 'Fire when record is viewed.'));
		echo $form->input('Condition.is_update', array('label' => 'Fire when record is udpated.'));
		echo $form->input('Condition.is_delete', array('label' => 'Fire when record is deleted.'));
		echo $form->input('Condition.plugin', array('after' => ' Plugin called to match against on view'));
		echo $form->input('Condition.controller', array('after' => ' Controller name to match on view'));
		echo $form->input('Condition.action', array('after' => ' Controller method to match on view'));
		echo $form->input('Condition.model', array('after' => ' The model for create, update, and view types'));
	?>
    </fieldset>
    <fieldset>
 		<legend><?php __('Extra Sub Conditions');?></legend>
    <?php
		echo $form->input('Condition.condition', array('label' => 'Sub Condtions', 'after' => ' Sub-conditions to match against. Model.field.operator.value,Model.field.operator.value'));
	?>
    </fieldset>
    <fieldset>
 		<legend><?php __('Model Calling This Condition');?></legend>
    <?php
		echo $form->input('Condition.bind_model', array('after' => ' The model calling this condition. Currently the only model supported is Workflows.Workflow', 'value' => 'Workflows.Workflow'));
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

<script type="text/javascript">
$(function() {
	$('#ConditionPlugin').parent().hide();
	$('#ConditionController').parent().hide();
	$('#ConditionAction').parent().hide();
	$('#ConditionModel').parent().hide();
	$('.checkbox input').change(function() {
	  // show necessary elements if it is a "read" type
	  if ($('#ConditionIsRead').is(':checked')) { 
			$('#ConditionPlugin').parent().show();
			$('#ConditionPlugin').parent().show();
			$('#ConditionController').parent().show();
			$('#ConditionAction').parent().show();
	  } else {
			$('#ConditionPlugin').parent().hide();
			$('#ConditionPlugin').parent().hide();
			$('#ConditionController').parent().hide();
			$('#ConditionAction').parent().hide();
	  }
	  
	  // show necessary elements if it is a "create", "update" or "delete" type
	  if ($('#ConditionIsCreate').is(':checked') || $('#ConditionIsUpdate').is(':checked') || $('#ConditionIsDelete').is(':checked')) { 
			$('#ConditionModel').parent().show();
	  } else {
			$('#ConditionModel').parent().hide();
	  }
	});
});
</script>
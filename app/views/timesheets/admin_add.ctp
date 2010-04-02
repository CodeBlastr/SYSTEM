<div class="timesheets form">
<?php echo $form->create(null, array('default' => false));?>
	<fieldset>
 		<legend><?php __('Timesheet Builder');?></legend>
	<?php
		echo $form->input('contact_id', array('type' => 'select', 'multiple' => true));
		echo $form->input('project_id', array('type' => 'select', 'multiple' => true ));
		echo $form->input('creator_id', array('type' => 'select', 'multiple' => true));
		echo $form->input('started_on', array('id' => 'StartedOn', 'class' => 'dateformat-Y-ds-m-ds-d statusformat-l-cc-sp-d-sp-F-sp-Y highlight-days-67 split-date opacity-90'), false);
		echo $form->input('ended_on', array('id' => 'EndedOn', 'class' => 'dateformat-Y-ds-m-ds-d statusformat-l-cc-sp-d-sp-F-sp-Y highlight-days-67 split-date opacity-90'), false);
	?>
	</fieldset>
	<?php echo $ajax->submit('Submit', array('url'=> array('controller'=>'timesheets', 'action'=>'edit'), 'update' => 'timesheetlist', 'indicator' => 'loadingimg', 'complete' => 'Modalbox.hide()')); ?>
</div>

<?php 
echo $ajax->observeForm('TimesheetAddForm', array('url'=> array('controller' => 'timesheets', 'action' => 'edit'), 'update' => 'timesheetlist', 'indicator' => 'loadingimg','onChange'=>true));
?>
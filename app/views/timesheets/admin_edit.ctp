<div class="timesheets form" id="timesheetlist">
<?php echo $form->create('Timesheet');?>
	<fieldset>
 		<legend><?php __('Create Timesheet');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('name');
		echo $form->input('TimesheetTime', array('type' => 'select', 'multiple' => 'checkbox'));
		echo $form->hidden('save');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>



<?php 
$menu->setValue(array($html->link(__('Search Times', true), '/admin/timesheets/add', array('title' => 'Search Times', 'onclick' => 'Modalbox.show(this.href, {title: this.title, width: 500}); return false;')))); 
?>
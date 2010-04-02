<div class="timesheets form">
<?php echo $form->create('Timesheet');?>
	<fieldset>
 		<legend><?php __('Add Timesheet');?></legend>
	<?php
		echo $form->input('name');
		echo $form->input('creator_id');
		echo $form->input('modifier_id');
		echo $form->input('TimesheetTime');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List Timesheets', true), array('action' => 'index'));?></li>
		<li><?php echo $html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Creator', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('List Timesheet Times', true), array('controller' => 'timesheet_times', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Timesheet Time', true), array('controller' => 'timesheet_times', 'action' => 'add')); ?> </li>
	</ul>
</div>

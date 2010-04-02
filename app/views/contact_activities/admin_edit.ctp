<div class="contactActivities form">
<?php echo $form->create('ContactActivity');?>
	<fieldset>
 		<legend><?php __('Edit Activity');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('contact_activity_type_id', array('label' => 'Type'));
		echo $form->input('name', array('label' => 'Subject'));
		echo $form->input('description');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>

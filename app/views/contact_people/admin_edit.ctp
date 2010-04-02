<div class="contactPeople form">
<?php echo $form->create('ContactPerson');?>
	<fieldset>
 		<legend><?php __('Contact Person');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('ContactPerson.contact_person_salutation_id', array('empty'=>true));
		echo $form->input('ContactPerson.first_name');
		echo $form->input('ContactPerson.last_name');
		echo $form->input('Contact.primary_email');
		
		echo $form->input('Contact.contact_type_id', array('empty'=>true, 'after' => '<p class="action">'.$html->link(__('Edit', true), array('controller' => 'contact_types', 'action' => 'index')).'</p>'));
		echo $form->input('Contact.contact_source_id', array('empty'=>true, 'after' => '<p class="action">'.$html->link(__('Edit', true), array('controller' => 'contact_sources', 'action' => 'index')).'</p>'));
		echo $form->input('Contact.contact_industry_id',array('empty'=>true, 'label'=>'Industry', 'after' => '<p class="action">'.$html->link(__('Edit', true), array('controller' => 'contact_industries', 'action' => 'index')).'</p>'));
		echo $form->input('Contact.contact_rating_id', array('empty'=>true, 'after' => '<p class="action">'.$html->link(__('Edit', true), array('controller' => 'contact_ratings', 'action' => 'index')).'</p>'));
				
		# this would be used for an affiliate app, so that you can identify the lead source
		# echo $form->input('Contact.ownedby_id');
		# echo $form->input('Contact.assignee_id', array('label'=>'Assignee','empty'=>true));
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
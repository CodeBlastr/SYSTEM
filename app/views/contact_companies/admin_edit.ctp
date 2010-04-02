<div class="contactCompanies form">
<?php echo $form->create('ContactCompany');?>
	<fieldset>
 		<legend><?php __('Contact Company');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('ContactCompany.name', array('label' => 'Company Name'));
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
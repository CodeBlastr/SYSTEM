<div class="contact form"> <?php echo $form->create('Contact');?>
  <fieldset>
    <legend>
    <?php __('Add a New Person');?>
    <?php echo $form->input('Contact.is_company', array('type' => 'hidden', 'value' => 0)); ?>
    </legend>
    <p>Only a name and a company are required, you can add anything else later if you like.</p>
    <?php
	 echo $form->input('Contact.name', array('label' => 'Name'));
	 echo $form->input('Employer', array('label' => 'What company is this person related to?', 'type' => 'select'));
	?>
  </fieldset>
  <fieldset>
    <legend class="toggleClick">
    <?php __('Would you like to add communication details?');?>
    </legend>
    <p>Add one contact detail for now, you can add all of the additional details you want after you save.</p>
    <?php
	 echo $form->input('ContactDetail.0.contact_detail_type_id', array('label' => $this->Html->link(__('Type', true), array('plugin' => null, 'controller' => 'enumerations', 'action' => 'index', 'filter' => 'CONTACTDETAIL', 'admin' => 1), array('class' => 'dialog', 'title' => 'Edit Detail List')))); 
	 echo $form->input('ContactDetail.0.value');
	?>
  <fieldset>
    <legend class="toggleClick">
    <?php __('Would you like to add some sales tracking data for this contact?');?>
    </legend>
    <?php
	 echo $form->input('Contact.contact_type_id', array('empty'=>true, 'label' => $this->Html->link(__('Type', true), array('plugin' => null, 'controller' => 'enumerations', 'action' => 'index', 'filter' => 'CONTACTTYPE', 'admin' => 1), array('class' => 'dialog', 'title' => 'Edit Type List'))));
	 echo $form->input('Contact.contact_source_id', array('empty'=>true, 'label' => $this->Html->link(__('Source', true), array('plugin' => null, 'controller' => 'enumerations', 'action' => 'index', 'filter' => 'CONTACTSOURCE', 'admin' => 1), array('class' => 'dialog', 'title' => 'Edit Source List'))));
	 echo $form->input('Contact.contact_industry_id',array('empty'=>true, 'label' => $this->Html->link(__('Industry', true), array('plugin' => null, 'controller' => 'enumerations', 'action' => 'index', 'filter' => 'CONTACTINDUSTRY', 'admin' => 1), array('class' => 'dialog', 'title' => 'Edit Industry List'))));
	 echo $form->input('Contact.contact_rating_id', array('empty'=>true, 'label' => $this->Html->link(__('Rating', true), array('plugin' => null, 'controller' => 'enumerations', 'action' => 'index', 'filter' => 'CONTACTRATING', 'admin' => 1), array('class' => 'dialog', 'title' => 'Edit Rating List'))));	
		# this would be used for an affiliate app, so that you can identify the lead source
		# echo $form->input('Contact.ownedby_id');
		# echo $form->input('Contact.assignee_id', array('label'=>'Assignee','empty'=>true));
	?>
  </fieldset>
  <fieldset>
    <legend class="toggleClick">
    <?php __('Would you like to log an activity performed so you can refer to it later?');?>
    </legend>
    <?php 
	 echo $form->input('ContactActivity.0.contact_activity_type_id', array('label' => $this->Html->link(__('Type', true), array('plugin' => null, 'controller' => 'enumerations', 'action' => 'index', 'filter' => 'CONTACTACTIVITY', 'admin' => 1), array('class' => 'dialog', 'title' => 'Edit Activity List')))); 
	 echo $form->input('ContactActivity.0.name', array('label' => 'Subject')); 
	 echo $form->input('ContactActivity.0.description');
	?>
  </fieldset>
  
  
  <?php /*  This is saved for later, when we add tasks table for contacts
  <fieldset>
    <legend class="toggleClick">
    <?php __('Any future opportunities or tasks you want to remind someone of?');?>
    </legend>
 	<?php 
	 echo $form->input('Task.enumeration_id', array('label' => $this->Html->link(__('Type', true), array('plugin' => null, 'controller' => 'enumerations', 'action' => 'index', 'filter' => 'TASKTYPE', 'admin' => 1), array('class' => 'dialog', 'title' => 'Edit Task List')))); 
	 echo $form->input('Task.name', array('label' => 'Subject')); 
	 echo $form->input('Task.description');
	 echo $form->input('Task.assignee_id', array('label' => 'Assign To'));
	 echo $form->input('Task.due_date', array('minYear' => date('Y'), 'maxYear' => date('Y') + 10, 'interval' =>  15));
 	?>
  </fieldset>
  */ ?>
  
  
  </fieldset>
  <?php echo $form->end('Submit');?> </div>

<div class="actions">
	<ul>
    	<li>Companies</li>
    	<li><?php echo $this->Html->link(__('List Companies', true), array('plugin' => 'contacts', 'controller' => 'contact_companies', 'action' => 'index')); ?></li>
    </ul>
</div>

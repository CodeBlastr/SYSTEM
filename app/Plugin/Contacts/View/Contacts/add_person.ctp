<div class="contact form"> <?php echo $this->Form->create('Contact');?>
  <fieldset>
    <legend> <?php echo __('Add a New Person');?>  </legend>
    <p>Only the person's name is required, you can add anything else later if you like.</p>
    <?php
	 echo $this->Form->hidden('Contact.is_company', array('value' => 0));
	 # @todo  :  this is not good for non-javascript browsers ( to be good for non-js we need to add a check for class == combobox to the formHelper and in that case output a text input instead of a select input
	 echo $this->Form->input('Contact.name', array('type' => 'select', 'options' => $people, 'label' => 'Name', 'class' => 'combobox', 'ifMatchName' => 'data[Contact][id]'));
	 echo $this->Form->input('Employer', array('label' => 'What company is this person related to?', 'type' => 'select'));
	?>
  </fieldset>
  <fieldset>
    <legend class="toggleClick"> <?php echo __('Would you like to add communication details?');?> </legend>
    <p>Add one contact detail for now, you can add all of the additional details you want after you save.</p>
    <?php
	 echo $this->Form->input('ContactDetail.0.contact_detail_type_id', array('label' => $this->Html->link(__('Type', true), array('plugin' => null, 'controller' => 'enumerations', 'action' => 'index', 'filter' => 'CONTACTDETAIL'), array('class' => 'dialog', 'title' => 'Edit Detail List')))); 
	 echo $this->Form->input('ContactDetail.0.value');
	?>
    <fieldset>
      <legend class="toggleClick"> <?php echo __('Would you like to add some sales tracking data for this contact?');?> </legend>
      <?php
	 echo $this->Form->input('Contact.contact_type_id', array('empty'=>true, 'label' => $this->Html->link(__('Type', true), array('plugin' => null, 'controller' => 'enumerations', 'action' => 'index', 'filter' => 'CONTACTTYPE'), array('class' => 'dialog', 'title' => 'Edit Type List'))));
	 echo $this->Form->input('Contact.contact_source_id', array('empty'=>true, 'label' => $this->Html->link(__('Source', true), array('plugin' => null, 'controller' => 'enumerations', 'action' => 'index', 'filter' => 'CONTACTSOURCE'), array('class' => 'dialog', 'title' => 'Edit Source List'))));
	 echo $this->Form->input('Contact.contact_industry_id',array('empty'=>true, 'label' => $this->Html->link(__('Industry', true), array('plugin' => null, 'controller' => 'enumerations', 'action' => 'index', 'filter' => 'CONTACTINDUSTRY'), array('class' => 'dialog', 'title' => 'Edit Industry List'))));
	 echo $this->Form->input('Contact.contact_rating_id', array('empty'=>true, 'label' => $this->Html->link(__('Rating', true), array('plugin' => null, 'controller' => 'enumerations', 'action' => 'index', 'filter' => 'CONTACTRATING'), array('class' => 'dialog', 'title' => 'Edit Rating List'))));	
		# this would be used for an affiliate app, so that you can identify the lead source
		# echo $this->Form->input('Contact.ownedby_id');
		# echo $this->Form->input('Contact.assignee_id', array('label'=>'Assignee','empty'=>true));
	?>
    </fieldset>
    <fieldset>
      <legend class="toggleClick"> <?php echo __('Would you like to log an activity performed so you can refer to it later?');?> </legend>
      <?php 
	 echo $this->Form->input('ContactActivity.0.contact_activity_type_id', array('label' => $this->Html->link(__('Type', true), array('plugin' => null, 'controller' => 'enumerations', 'action' => 'index', 'filter' => 'CONTACTACTIVITY', 'admin' => 1), array('class' => 'dialog', 'title' => 'Edit Activity List')))); 
	 echo $this->Form->input('ContactActivity.0.name', array('label' => 'Subject')); 
	 echo $this->Form->input('ContactActivity.0.description');
	?>
    </fieldset>
    <?php /*  This is saved for later, when we add tasks table for contacts
  <fieldset>
    <legend class="toggleClick">
    <?php echo __('Any future opportunities or tasks you want to remind someone of?');?>
    </legend>
 	<?php 
	 echo $this->Form->input('Task.enumeration_id', array('label' => $this->Html->link(__('Type', true), array('plugin' => null, 'controller' => 'enumerations', 'action' => 'index', 'filter' => 'TASKTYPE', 'admin' => 1), array('class' => 'dialog', 'title' => 'Edit Task List')))); 
	 echo $this->Form->input('Task.name', array('label' => 'Subject')); 
	 echo $this->Form->input('Task.description');
	 echo $this->Form->input('Task.assignee_id', array('label' => 'Assign To'));
	 echo $this->Form->input('Task.due_date', array('minYear' => date('Y'), 'maxYear' => date('Y') + 10, 'interval' =>  15));
 	?>
  </fieldset>
  */ ?>
  </fieldset>
  <?php echo $this->Form->end('Submit');?> </div>

<?php
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Companies',
		'items' => array(
			$this->Html->link(__('List', true), array('action' => 'index')),
			),
		),
	))); 
?>
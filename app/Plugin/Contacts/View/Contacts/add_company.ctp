<div class="contact form">
<?php echo $this->Form->create('Contact');?>
  <fieldset>
    <?php
	 echo $this->Form->hidden('Contact.is_company', array('value' => 1));
	 echo $this->Form->input('Contact.name', array('label' => 'Name, <small><i>(Only a company name is required.)</i></small>'));
	 echo $this->Form->input('ContactDetail.0.contact_detail_type', array('label' => false, 'class' => 'span1', 'after' => ' ' . $this->Form->input('ContactDetail.0.value', array('label' => false, 'div' => false, 'after' => ' ' . $this->Html->link(__('Edit Detail Types'), array('plugin' => null, 'controller' => 'enumerations', 'action' => 'index', 'filter' => 'type:CONTACT_DETAIL'), array('class' => 'dialog', 'title' => 'Edit Detail Types')))))); ?>
  </fieldset>
  
  <fieldset>
    <legend class="toggleClick">
    <?php echo __('Label this contact, for sorting?');?>
    </legend>
    <?php
	 echo $this->Form->input('Contact.contact_type_id', array('empty'=>true, 'label' => $this->Html->link(__('Type', true), array('plugin' => null, 'controller' => 'enumerations', 'action' => 'index', 'filter' => 'type:CONTACT_TYPE'), array('class' => 'dialog', 'title' => 'Edit Type List'))));
	 echo $this->Form->input('Contact.contact_source_id', array('empty'=>true, 'label' => $this->Html->link(__('Source', true), array('plugin' => null, 'controller' => 'enumerations', 'action' => 'index', 'filter' => 'type:CONTACT_SOURCE'), array('class' => 'dialog', 'title' => 'Edit Source List'))));
	 echo $this->Form->input('Contact.contact_industry_id',array('empty'=>true, 'label' => $this->Html->link(__('Industry', true), array('plugin' => null, 'controller' => 'enumerations', 'action' => 'index', 'filter' => 'type:CONTACT_INDUSTRY'), array('class' => 'dialog', 'title' => 'Edit Industry List'))));
	 echo $this->Form->input('Contact.contact_rating_id', array('empty'=>true, 'label' => $this->Html->link(__('Rating', true), array('plugin' => null, 'controller' => 'enumerations', 'action' => 'index', 'filter' => 'type:CONTACT_RATING'), array('class' => 'dialog', 'title' => 'Edit Rating List')))); ?>
  </fieldset>
  <fieldset>
    <legend class="toggleClick">
    <?php echo __('Log an activity for this contact?');?>
    </legend>
    <?php 
	 echo $this->Form->input('ContactActivity.0.contact_activity_type_id', array('label' => $this->Html->link(__('Type', true), array('plugin' => null, 'controller' => 'enumerations', 'action' => 'index', 'filter' => 'type:CONTACT_ACTIVITY'), array('class' => 'dialog', 'title' => 'Edit Activity Types')))); 
	 echo $this->Form->input('ContactActivity.0.name', array('label' => 'Subject')); 
	 echo $this->Form->input('ContactActivity.0.description'); ?>
  </fieldset>
  
  <fieldset>
    <legend class="toggleClick">
    <?php echo __('Create an opportunity for this contact?');?>
    </legend>
 	<?php 
	 echo $this->Form->input('Task.enumeration_id', array('label' => $this->Html->link(__('Type', true), array('plugin' => null, 'controller' => 'enumerations', 'action' => 'index', 'filter' => 'TASKTYPE', 'admin' => 1), array('class' => 'dialog', 'title' => 'Edit Task List')))); 
	 echo $this->Form->input('Task.name', array('label' => 'Subject')); 
	 echo $this->Form->input('Task.description');
	 echo $this->Form->input('Task.assignee_id', array('label' => 'Assign To'));
	 echo $this->Form->input('Task.due_date', array('minYear' => date('Y'), 'maxYear' => date('Y') + 10, 'interval' =>  15)); ?>
  </fieldset>
  
  <?php echo $this->Form->end('Submit');?>
</div>

<?php
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Contacts',
		'items' => array(
			$this->Html->link(__('Companies'), array('plugin' => 'contacts', 'controller'=> 'contacts', 'action' => 'index'), array('data-icon' => 'grid')),
			$this->Html->link(__('People'), array('plugin' => 'contacts', 'controller'=> 'contacts', 'action' => 'people'), array('data-icon' => 'grid')),
			),
		),
	)));  ?>
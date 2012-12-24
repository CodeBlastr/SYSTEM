<div class="contact form">
<?php echo $this->Form->create('Contact');?>
  <fieldset>
    <?php
	 echo $this->Form->hidden('Contact.is_company', array('value' => 1));
	 echo $this->Form->input('Contact.name', array('label' => 'Name, <small><i>(Only a company name is required.)</i></small>'));
	 echo $this->Form->input('ContactDetail.0.contact_detail_type', array('label' => false, 'class' => 'span1', 'after' => ' ' . $this->Form->input('ContactDetail.0.value', array('label' => false, 'type' => 'text', 'class' => 'span2', 'div' => false, 'after' => ' ' . $this->Html->link(__('Edit Detail Types'), array('plugin' => null, 'controller' => 'enumerations', 'action' => 'index', 'filter' => 'type:CONTACT_DETAIL'), array('class' => 'dialog', 'title' => 'Edit Detail Types')))))); ?>
  </fieldset>
  
  <fieldset>
    <legend>
    <?php echo __('Helpful identification labels');?>
    </legend>
    <?php
	 echo $this->Form->input('Contact.contact_type', array('default' => 'lead', 'label' => $this->Html->link(__('Type'), array('plugin' => null, 'controller' => 'enumerations', 'action' => 'index', 'filter' => 'type:CONTACT_TYPE'), array('class' => 'dialog', 'title' => 'Edit Type List'))));
	 echo $this->Form->input('Contact.contact_rating', array('default' => 'hot', 'label' => $this->Html->link(__('Rating'), array('plugin' => null, 'controller' => 'enumerations', 'action' => 'index', 'filter' => 'type:CONTACT_RATING'), array('class' => 'dialog', 'title' => 'Edit Rating List'))));
	 echo $this->Form->input('Contact.contact_source', array('empty'=>true, 'label' => $this->Html->link(__('Source'), array('plugin' => null, 'controller' => 'enumerations', 'action' => 'index', 'filter' => 'type:CONTACT_SOURCE'), array('class' => 'dialog', 'title' => 'Edit Source List'))));
	 echo $this->Form->input('Contact.contact_industry',array('empty'=>true, 'label' => $this->Html->link(__('Industry'), array('plugin' => null, 'controller' => 'enumerations', 'action' => 'index', 'filter' => 'type:CONTACT_INDUSTRY'), array('class' => 'dialog', 'title' => 'Edit Industry List')))); ?>
  </fieldset>
  
  <?php /* These aren't being used at all, removed 11/26/2012
   * 
   * if (in_array('Estimates', CakePlugin::loaded())) { ?>
  <fieldset>
    <legend class="toggleClick">
    <?php echo __('Create an opportunity?');?>
    </legend>
 	<?php 
	 echo $this->Form->input('Estimate.0.model', array('type' => 'hidden', 'value' => 'Contact')); 
	 echo $this->Form->input('Estimate.0.total', array('label' => 'Value')); 
	 echo $this->Form->input('Estimate.0.description', array('type' => 'richtext')); ?>
  </fieldset>
  <?php } ?>
  
  <?php if (in_array('Activities', CakePlugin::loaded())) { ?>
  <fieldset>
    <legend class="toggleClick">
    <?php echo __('Log an activity for this contact?');?>
    </legend>
    <?php 
	 echo $this->Form->input('Activity.0.model', array('type' => 'hidden', 'value' => 'Contact')); 
	 echo $this->Form->input('Activity.0.action_description', array('type' => 'hidden', 'value' => 'contact activity')); 
	 echo $this->Form->input('Activity.0.name', array('label' => 'Subject')); 
	 echo $this->Form->input('Activity.0.description', array('type' => 'richtext')); ?>
  </fieldset>
  <?php } ?>
  
  <?php if (in_array('Tasks', CakePlugin::loaded())) { ?>
  <fieldset>
    <legend class="toggleClick">
    <?php echo __('Create a follow up task for this contact?');?>
    </legend>
 	<?php 
	 echo $this->Form->input('Task.0.model', array('type' => 'hidden', 'value' => 'Contact')); 
	 echo $this->Form->input('Task.0.assignee_id', array('label' => 'Assign To'));
	 echo $this->Form->input('Task.0.due_date', array('minYear' => date('Y'), 'maxYear' => date('Y') + 10, 'interval' =>  15));
	 echo $this->Form->input('Task.0.name', array('label' => 'Subject')); 
	 echo $this->Form->input('Task.0.description', array('type' => 'richtext')); ?>
  </fieldset>
  <?php } */ ?>
  
  
  <?php echo $this->Form->end('Submit');?>
</div>

<?php
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Contacts',
		'items' => array(
			$this->Html->link(__('Dashboard'), array('plugin' => 'contacts', 'controller' => 'contacts', 'action' => 'dashboard')),
			),
		),
	array(
		'heading' => 'Contacts',
		'items' => array(
			$this->Html->link(__('Companies'), array('plugin' => 'contacts', 'controller'=> 'contacts', 'action' => 'index'), array('data-icon' => 'grid')),
			$this->Html->link(__('People'), array('plugin' => 'contacts', 'controller'=> 'contacts', 'action' => 'people'), array('data-icon' => 'grid')),
			),
		),
	)));  ?>
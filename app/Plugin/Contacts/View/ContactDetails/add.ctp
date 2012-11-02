<div class="contactDetails form">
<?php echo $this->Form->create('ContactDetail');?>
	<fieldset>
 		<legend><?php echo __('Add Contact Detail'); ?></legend>
	<?php
		echo $this->Form->input('contact_detail_type');
		echo $this->Form->input('value');
		//echo $this->Form->input('primary');
		echo $this->Form->input('contact_id', array('default' => $contactId));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<?php 
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Contact Details',
		'items' => array(
			$this->Html->link(__('List'), array('action' => 'index')),
			$this->Html->link(__('Detail Types'), array('controller' => 'enumerations', 'action' => 'add')),
			$this->Html->link(__('View Contact'), array('controller' => 'contacts', 'action' => 'view', $contactId)),
			$this->Html->link(__('List Contacts'), array('controller' => 'contacts', 'action' => 'index')),
			)
		),
	)));
?>
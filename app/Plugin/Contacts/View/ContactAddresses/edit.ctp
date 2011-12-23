<div class="contactAddresses form">
<?php echo $this->Form->create('ContactAddress');?>
	<fieldset>
 		<legend><?php echo __('Edit Contact Address'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('contact_address_type_id');
		echo $this->Form->input('street1');
		echo $this->Form->input('street2');
		echo $this->Form->input('city');
		echo $this->Form->input('state_id');
		echo $this->Form->input('zip_postal');
		echo $this->Form->input('country_id');
		echo $this->Form->input('primary');
		echo $this->Form->input('contact_id');
		echo $this->Form->input('creator_id');
		echo $this->Form->input('modifier_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<?php 
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Contact Address',
		'items' => array(
			$this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('ContactAddress.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('ContactAddress.id'))),
			$this->Html->link(__('List Contact Addresses', true), array('action' => 'index')),
			$this->Html->link(__('List Enumerations', true), array('controller' => 'enumerations', 'action' => 'index')),
			$this->Html->link(__('New Contact Address Type', true), array('controller' => 'enumerations', 'action' => 'add')),
			$this->Html->link(__('List Contacts', true), array('controller' => 'contacts', 'action' => 'index')),
			$this->Html->link(__('New Contact', true), array('controller' => 'contacts', 'action' => 'add')),
			)
		),
	)));
?>
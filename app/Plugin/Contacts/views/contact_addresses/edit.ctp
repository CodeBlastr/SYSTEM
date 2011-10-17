<div class="contactAddresses form">
<?php echo $this->Form->create('ContactAddress');?>
	<fieldset>
 		<legend><?php __('Edit Contact Address'); ?></legend>
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
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('ContactAddress.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('ContactAddress.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Contact Addresses', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Enumerations', true), array('controller' => 'enumerations', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Contact Address Type', true), array('controller' => 'enumerations', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Contacts', true), array('controller' => 'contacts', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Contact', true), array('controller' => 'contacts', 'action' => 'add')); ?> </li>
	</ul>
</div>
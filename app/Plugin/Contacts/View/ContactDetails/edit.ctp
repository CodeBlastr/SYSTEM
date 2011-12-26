<div class="contactDetails form">
<?php echo $this->Form->create('ContactDetail');?>
	<fieldset>
 		<legend><?php echo __('Edit Contact Detail'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('contact_detail_type_id');
		echo $this->Form->input('value');
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
		'heading' => 'Contact Detail',
		'items' => array(
			$this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('ContactDetail.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('ContactDetail.id'))),
			$this->Html->link(__('List Contact Details', true), array('action' => 'index')),
			$this->Html->link(__('List Enumerations', true), array('controller' => 'enumerations', 'action' => 'index')),
			$this->Html->link(__('New Contact Detail Type', true), array('controller' => 'enumerations', 'action' => 'add')),
			$this->Html->link(__('List Contacts', true), array('controller' => 'contacts', 'action' => 'index')),
			$this->Html->link(__('New Contact', true), array('controller' => 'contacts', 'action' => 'add')),
			)
		),
	)));
?>
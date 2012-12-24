<div class="contactDetails form">
	<?php echo $this->Form->create('ContactDetail');?>
	<fieldset>
		<?php
		echo $this->Form->input('ContactDetail.id');
		echo $this->Form->hidden('ContactDetail.contact_id');
		echo $this->Form->input('ContactDetail.contact_detail_type', array('label' => 'Label', 'empty' => 'Choose one...'));
		echo $this->Form->input('ContactDetail.value'); ?>
	</fieldset>
	<?php echo $this->Form->end('Save'); ?>
</div>
<?php 
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Contact Detail',
		'items' => array(
			$this->Html->link(__('Delete %s', $this->Form->value('ContactDetail.contact_detail_type')), array('action' => 'delete', $this->Form->value('ContactDetail.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('ContactDetail.id'))),
			),
		),
	array(
		'heading' => 'Contacts',
		'items' => array(
			$this->Html->link(__('View %s', $this->request->data['Contact']['name']), array('controller' => 'contacts', 'action' => 'view', $this->request->data['Contact']['id'])),
			$this->Html->link(__('All Contacts'), array('controller' => 'contacts', 'action' => 'index')),
			)
		),
	))); ?>
<div class="contactDetails form">
	<?php echo $this->Form->create('ContactDetail');?>
	<fieldset>
		<h1><?php echo __('Edit %s', $this->request->data['Contact']['name']); ?></h1>
		<h3><?php echo __('Contact Detail'); ?></h3>
 		<legend></legend>
		<?php
		echo $this->Form->input('id');
		echo $this->Form->input('contact_detail_type', array('label' => 'Label', 'empty' => 'Choose one...'));
		echo $this->Form->input('value'); ?>
	</fieldset>
	<?php echo $this->Form->end(); ?>
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
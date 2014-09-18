<div class="contact estimate form">
	<?php
	echo $this->Form->create(); ?>
	<fieldset>
		<?php echo $this->Form->input('Estimate.id'); ?>
		<?php echo $this->Form->input('Estimate.model', array('type' => 'hidden', 'value' => 'Contact')); ?> 
		<?php echo $this->Form->input('Estimate.foreign_key', array('type' => 'hidden', 'value' => $contact['Contact']['id'])); ?> 
		<?php echo $this->Form->input('Estimate.total', array('label' => 'Opportunity Value (XXXX.XX format)', 'required' => 'required')); ?>
		<?php echo $this->Form->input('Estimate.introduction', array('label' => 'Recipient - <small> - supports <a href="http://daringfireball.net/projects/markdown/syntax" target="_blank">markdown syntax</a></small>')); ?>
		<?php echo $this->Form->input('Estimate.description', array('label' => 'Scope', 'type' => 'richtext')); ?>
	</fieldset>
  	<?php echo $this->Form->submit('Save & Send', array('div' => false, 'class' => 'pull-right', 'name' => 'data[Estimate][submit]'));?>
  	<?php echo $this->Form->submit('Save & View', array('div' => false, 'name' => 'data[Estimate][submit]'));?>
  	<?php echo $this->Form->submit('Save & Continue Editing', array('div' => false, 'name' => 'data[Estimate][submit]'));?>
  	<?php echo $this->Form->end(); ?>
</div>

<?php 
// set the contextual breadcrumb items
$this->set('context_crumbs', array('crumbs' => array(
	$this->Html->link(__('Dashboard'), array('action' => 'dashboard')),
	$this->Html->link($contact['Contact']['name'], array('action' => 'view', $contact['Contact']['id'])),
	__('Proposal Buildrr')
)));

// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Contacts',
		'items' => array(
			$this->Html->link(__('View %s', $contact['Contact']['name']), array('action' => 'view', $contact['Contact']['id'])),
			$this->Html->link(__('View'), array('action' => 'estimated', $estimate['Estimate']['id'])),
			!empty($estimate['Estimate']['id']) ? $this->Html->link('Public View', array('action' => 'proposal', $estimate['Estimate']['id'])) : null,
			$this->Html->link(__('Delete'), array('action' => 'unestimate', $estimate['Estimate']['id'], $estimate['Contact']['id']), null, __('Are you sure?')),
			)
		),
	)));
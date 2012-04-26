<div class="contacts form">
<?php echo $this->Form->create('Contact');?>
	<fieldset>
 		<legend><?php echo __('Edit Contact'); ?></legend>
		<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('contact_type_id');
		echo $this->Form->input('contact_source_id');
		echo $this->Form->input('contact_industry_id');
		echo $this->Form->input('contact_rating_id');
		echo $this->Form->input('user_id', array('empty' => '-- Select User --'));
		echo $this->Form->input('is_company'); ?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<?php 
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Projects',
		'items' => array(
			$this->Html->link(__('List'), array('action' => 'index'), array('class' => 'index')),
			$this->Html->link(__('Add'), array('controller' => 'contacts', 'action' => 'add'), array('class' => 'add')),
			$this->Html->link(__('Delete'), array('action' => 'delete', $this->Form->value('Contact.id')), array('class' => 'delete'), sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Contact.id'))),
			)
		),
	))); ?>
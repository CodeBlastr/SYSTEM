<div class="contact estimate form">
	<?php
	echo $this->Form->create(); ?>
	<fieldset>
		<?php 
		echo $this->Form->input('Estimate.model', array('type' => 'hidden', 'value' => 'Contact')); 
		echo $this->Form->input('Estimate.foreign_key', array('type' => 'hidden', 'value' => $contact['Contact']['id'])); 
		echo $this->Form->input('Estimate.total', array('label' => 'Opportunity Value (XXXX.XX format)')); 
		echo $this->Form->input('Estimate.description', array('type' => 'richtext')); ?>
	</fieldset>
  	<?php echo $this->Form->end('Submit');?>
</div>

<?php 
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Contacts',
		'items' => array(
			$this->Html->link(__('View %s', $contact['Contact']['name']), array('action' => 'view', $contact['Contact']['id'])),
			)
		),
	))); ?>
<div class="contact estimate form">
	<?php
	echo $this->Form->create(); ?>
	<fieldset>
		<?php 
		echo $this->Form->input('Activity.model', array('type' => 'hidden', 'value' => 'Contact')); 
		echo $this->Form->input('Activity.foreign_key', array('type' => 'hidden', 'value' => $contact['Contact']['id'])); 
	 	echo $this->Form->input('Activity.action_description', array('type' => 'hidden', 'value' => 'contact activity')); 
	 	echo $this->Form->input('Activity.name', array('label' => 'Subject <em>(ex. Sent an email)</em>')); 
	 	echo $this->Form->input('Activity.created', array('label' => 'Date of Activity', 'type' => 'date', 'value' => date('Y-m-d'))); 
	 	echo $this->Form->input('Activity.description', array('type' => 'richtext')); ?>
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
<div class="contact estimate form">
	<?php
	echo $this->Form->create(); ?>
	<fieldset>
		<?php 
		echo $this->Form->input('Task.model', array('type' => 'hidden', 'value' => 'Contact')); 
		echo $this->Form->input('Task.foreign_key', array('type' => 'hidden', 'value' => $contact['Contact']['id'])); 
	 	echo $this->Form->input('Task.assignee_id', array('label' => 'Assign To', 'default' => $this->Session->read('Auth.User.id')));
	 	echo $this->Form->input('Task.due_date', array('minYear' => date('Y'), 'maxYear' => date('Y') + 10, 'interval' =>  15));
	 	echo $this->Form->input('Task.name', array('label' => 'Subject <em>(ex. Call back)</em>')); 
		echo $this->Form->input('Task.description', array('type' => 'richtext')); ?>
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
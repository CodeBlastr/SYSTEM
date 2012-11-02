<?php
echo $this->Form->create('', array('type' => 'get')); 
echo $this->Form->input('start:name', array('label' => 'Name'));
echo $this->Form->end('Search');


echo $this->Element('scaffolds/index', array('data' => $contacts));


// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => '',
		'items' => array(
			$this->Html->link(__('Dashboard'), array('plugin' => 'contacts', 'controller'=> 'contacts', 'action' => 'dashboard')),
			),
		),
	array(
		'heading' => '',
		'items' => array(
			$this->Html->link(__('Leads'), array('plugin' => 'contacts', 'controller'=> 'contacts', 'action' => 'index', 'filter' => 'contact_type:lead')),
			$this->Html->link(__('Companies'), '/contacts/contacts/index/filter:is_company:1/filter:contact_type:customer'),
			$this->Html->link(__('People'), '/contacts/contacts/index/filter:is_company:0/filter:contact_type:customer'),
			),
		),
	array(
		'heading' => '',
		'items' => array(
			$this->Html->link(__('Add'), array('plugin' => 'contacts', 'controller'=> 'contacts', 'action' => 'add')),
			),
		),
	))); ?>
	
<script type="text/javascript">
$(function() {
	//alert('red');
});
</script>
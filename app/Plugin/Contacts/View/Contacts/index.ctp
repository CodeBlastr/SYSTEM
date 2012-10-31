<?php
echo $this->Element('scaffolds/index', array('data' => $contacts));


// set the contextual menu items
$this->set('context_menu', array('menus' => array(
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
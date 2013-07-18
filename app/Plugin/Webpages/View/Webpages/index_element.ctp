<?php
echo $this->Element('scaffolds/index', array('data' => $webpages));

// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Webpages',
		'items' => array(
			$this->Paginator->sort('name'),
			$this->Html->link(__('Add'), array('controller' => 'webpages', 'action' => 'add', 'element')),
			)
		),
	)));
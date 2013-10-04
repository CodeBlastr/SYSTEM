<?php
echo $this->Element('scaffolds/index', array(
	'data' => $webpages,
    'actions' => array(
        //$this->Html->link('View', array('plugin' => 'projects', 'controller' => 'projects', 'action' => 'view', '{id}')),
        $this->Html->link('Edit', array('plugin' => 'webpages', 'controller' => 'webpages', 'action' => 'edit', '{id}')),
        $this->Html->link('Export', array('plugin' => 'webpages', 'controller' => 'webpages', 'action' => 'export', '{id}')),
        )	
	));

// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Webpages',
		'items' => array(
			$this->Paginator->sort('name'),
			$this->Html->link(__('Add'), array('controller' => 'webpages', 'action' => 'add', 'template')),
			)
		),
	)));
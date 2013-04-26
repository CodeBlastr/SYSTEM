<?php

echo $this->Element('scaffolds/index', array(
    'data' => $webpages, 
	'actions' => array(
		$this->Html->link('View', array('plugin' => 'webpages', 'controller' => 'webpages', 'action' => 'view', '{id}')),
		$this->Html->link('Edit', array('plugin' => 'webpages', 'controller' => 'webpages', 'action' => 'edit', '{id}')),
		)
    ));

// set contextual search options
$this->set('forms_search', array(
    'url' => '/webpages/webpages/index/', 
	'inputs' => array(
		array(
			'name' => 'contains:name', 
			'options' => array(
				'label' => '', 
				'placeholder' => 'Type Your Search and Hit Enter',
				'value' => !empty($this->request->params['named']['contains']) ? substr($this->request->params['named']['contains'], strpos($this->request->params['named']['contains'], ':') + 1) : null,
				)
			),
		/*array(
			'name' => 'filter:contact_type', 
			'options' => array(
				'type' => 'select',
				'empty' => '-- All --',
				'options' => array(
					'lead' => 'Lead',
					'customer' => 'Customer',
					),
				'label' => '', 
				'placeholder' => 'Type Your Search and Hit Enter'
				)
			)*/
		)
	));
    
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Parent',
		'items' => array(
            $this->Html->link(__('Edit %s Page', $webpages[0]['Parent']['name']), array('action' => 'edit', $webpages[0]['Parent']['id'])),
            )
		),
	array(
		'heading' => 'Webpages',
		'items' => array(
            $this->Html->link(__('All Pages'), array('controller' => 'webpages', 'action' => 'index')),
            $this->Html->link(__('Add Page'), array('controller' => 'webpages', 'action' => 'add', 'sub', $webpages[0]['Parent']['id'])),
            )
		),
	)));
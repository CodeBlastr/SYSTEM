<?php
echo $this->Element('scaffolds/index', array(
    'data' => $webpages, 
	'actions' => array(
		$this->Html->link('View', array('plugin' => 'webpages', 'controller' => 'webpages', 'action' => 'view', '{id}')),
		$this->Html->link('Edit', array('plugin' => 'webpages', 'controller' => 'webpages', 'action' => 'edit', '{id}')),
		$this->Html->link('Convert to Section', array('plugin' => 'webpages', 'controller' => 'webpages', 'action' => 'add', 'sub', '{id}')),
		)
    ));


$items = '';
foreach ($sections as $section) {
    $items[] = $this->Html->link($section['Parent']['name'], array('plugin' => 'webpages', 'controller' => 'webpages', 'action' => 'index', 'sub', 'filter' => 'parent_id:' . $section['Parent']['id']));
}

// set the contextual sorting items
//echo $this->Element('context_sort', array(
//    'context_sort' => array(
//        'type' => 'select',
//        'sorter' => array(array(
//            'heading' => '',
//            'items' => array(
//                $this->Paginator->sort('name'),
//                $this->Paginator->sort('created'),
//                )
//            )), 
//        )
//    )); 
  
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
		'heading' => 'Sections',
		'items' => $items,
		),
	array(
		'heading' => 'Sections',
		'items' => array(
            $this->Html->link(__('Add'), array('controller' => 'webpages', 'action' => 'add', 'sub')) 
            ),
		),
	array(
		'heading' => 'Page Types',
		'items' => array(
            $this->Html->link(__('Add'), array('controller' => 'webpages', 'action' => 'addPageType')) 
            ),
		),
	)));
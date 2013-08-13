<?php 
echo $this->Element('scaffolds/index', array('data' => $users)); 

    
// set contextual search options
$this->set('forms_search', array(
    'url' => '/users/users/index/', 
	'inputs' => array(
		array(
			'name' => 'contains:full_name', 
			'options' => array(
				'label' => '', 
				'placeholder' => 'Search Users',
				'value' => !empty($this->request->params['named']['contains']) ? substr($this->request->params['named']['contains'], strpos($this->request->params['named']['contains'], ':') + 1) : null,
				)
			),
		)
	));
	
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Users',
		'items' => array(
			 $this->Html->link(__('New User', true), array('action' => 'register')),
			 )
		),
	array(
		'heading' => 'User Roles',
		'items' => array(
			 $this->Html->link(__('List User Roles', true), array('controller' => 'user_roles', 'action' => 'index')),
			 )
		),
	)));?>

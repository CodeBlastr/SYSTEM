<?php
echo $this->Element('scaffolds/index', array('data' => $aliases, 'actions' => array(
    $this->Html->link('Edit', array('plugin' => null, 'controller' => 'aliases', 'action' => 'edit', '{id}'))
)));

// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Aliases',
		'items' => array(
			$this->Html->link(__('Add'), array('controller' => 'aliases', 'action' => 'add')),
			)
		),
	)));
<?php
echo $this->Element('scaffolds/index', array('data' => $menus));

// set the contextual menu items
$this->set('context_menu', array('menus' => array(
    array(
		'heading' => 'Menus',
		'items' => array(
			$this->Html->link(__('Add'), array('action' => 'add')),
			$this->Html->link(__('List'), array('controller' => 'webpage_menus', 'action' => 'index')),
			)
		),
	)));
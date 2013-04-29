<?php

echo $this->Element('scaffolds/index', array('data' => $settings));


// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Projects',
		'items' => array(
			$this->Html->link(__('Add'), array('admin' => true, 'plugin' => null, 'controller' => 'settings', 'action' => 'add')),
			$this->Html->link(__('Test Mail'), array('admin' => true, 'plugin' => null, 'controller' => 'settings', 'action' => 'test')),
			)
		),
	))); ?>
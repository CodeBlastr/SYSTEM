<?php
echo $this->Element('scaffolds/index', array('data' => $webpageJses));

// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Webpage Js',
		'items' => array(
			$this->Html->link(__('Add'), array('controller' => 'webpage_jses', 'action' => 'add')),
			)
		),
	)));
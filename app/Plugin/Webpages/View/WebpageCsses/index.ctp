<?php
echo $this->Element('scaffolds/index', array('data' => $webpageCsses));

// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Webpage Css',
		'items' => array(
			$this->Paginator->sort('name'),
			$this->Html->link(__('Add'), array('controller' => 'webpage_csses', 'action' => 'add')),
			)
		),
	)));
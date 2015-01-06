<?php
echo $this->Html->meta('keywords', $webpage['Webpage']['keywords'], array('inline' => false));
echo $this->Html->meta('description', $webpage['Webpage']['description'], array('inline' => false));

echo $webpage['Webpage']['content'];
 
// set the contextual menu items      
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Webpages',
		'items' => array(
			//$this->element('Webpages.menus', array('id' => 'main-menu')),
			preg_replace('/<ul(.*?)>/i', '', strrev(preg_replace('/>lu\/</i', '', strrev($this->element('Webpages.menus', array('id' => 'main-menu'))), 1)), 1), // replace the last </ul> and the first <ul (.*) >
			$this->Html->link(__('All Pages'), array('controller' => 'webpages', 'action' => 'index')),
			$this->Html->link(__('Edit'), array('admin' => true, 'controller' => 'webpages', 'action' => 'edit', $webpage['Webpage']['id'])),
			$this->Html->link(__('Delete'), array('controller' => 'webpages', 'action' => 'delete', $webpage['Webpage']['id']), array(), 'Are you sure you want to delete "'.strip_tags($webpage['Webpage']['title']).'"'),
			)
		),
	)));

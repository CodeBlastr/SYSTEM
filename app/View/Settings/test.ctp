
<?php 
echo $this->Form->create();
echo $this->Form->input('to');
echo $this->Form->input('subject');
echo $this->Form->input('message', array('type' => 'textarea'));
echo $this->Form->end('Send');
	
// set the contextual breadcrumb items
$this->set('context_crumbs', array('crumbs' => array(
	$this->Html->link(__('Admin Dashboard'), '/admin'),
	$page_title_for_layout,
)));

// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Settings',
		'items' => array(
			$this->Html->link(__('List Settings'), array('action' => 'index'))
			)
		),
	)));

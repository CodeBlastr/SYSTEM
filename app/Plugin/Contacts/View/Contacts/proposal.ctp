
<?php debug($estimate); ?>



<?php 
// set the contextual breadcrumb items
$this->set('context_crumbs', array('crumbs' => array(
	$this->Html->link(__('Dashboard'), array('action' => 'dashboard')),
	$this->Html->link($estimate['Contact']['name'], array('action' => 'view', $estimate['Contact']['id'])),
	__('Proposal Buildrr')
)));

// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Contacts',
		'items' => array(
			$this->Html->link(__('Edit'), array('action' => 'estimate', $estimate['Contact']['id'], $estimate['Estimate']['id'])),
			)
		),
	)));

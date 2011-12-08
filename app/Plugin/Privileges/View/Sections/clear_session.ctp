<div class="privileges">
	<h1>Session Readout: </h1>
    <pre>
	<?php print_r(CakeSession::read('Privileges.lastPlugin')); ?>
    </pre>
</div>


<?php
// set the contextual menu items
echo $this->Element('context_menu', array('menus' => array(
	array(
		'heading' => 'Actions',
		'items' => array(
			$this->Html->link(__('Run Aco Sync', true), array('plugin' => 'privileges', 'controller' => 'sections', 'action' => 'aco_sync')),
			$this->Html->link(__('Manage Privileges', true), array('plugin' => 'privileges', 'controller' => 'sections', 'action' => 'index')),
			)
		),
	)));
?>

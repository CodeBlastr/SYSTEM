<div class="privileges">
	<h2> Sync privileges with latest system updates. </h2>
    <p> You are clear to sync sections with latest updates to the system. </p>
    <p> This could take quite awhile if you have a lot of plugins enabled. </p> 
    <p> Once you start it must run to completion, without exiting the browser. </p>
    <p> To run the update click this link : <?php echo $this->Html->link(__(' Run Update ', true), array('plugin' => 'privileges', 'controller' => 'sections', 'action' => 'aco_sync')); ?></p>
    
   	<p> For your information, these are your currently enabled plugin : </p>
    <ul>
    <?php foreach (CakePlugin::loaded() as $plugin) { echo '<li>' . $plugin . '</li>'; } ?>
    </ul>
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

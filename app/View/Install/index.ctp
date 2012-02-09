<div class="install index masonry">
	<h1>Plugins available to install</h1>
	<?php
    if (!empty($unloadedPlugins)) {
		foreach ($unloadedPlugins as $unloadedPlugin) { ?>
			<div class="masonryBox"><?php echo $this->Html->link(__('Install %s', $unloadedPlugin), array('action' => 'plugin', $unloadedPlugin)); ?></div>
    <?php
		}
	} else { ?>
    	<p> No available plugins to install. </p>
    <?php
	} ?>
</div>


<?php 
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Install',
		'items' => array(
			$this->Html->link(__('Add Site'), array('action' => 'site')),
			)
		),
	))); ?>
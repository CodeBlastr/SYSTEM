<div class="install index masonry">
	<h1>Plugins available to uninstall</h1>
	<ul>
	<?php foreach ($plugins as $plugin) :?>
		<li>
			<?php echo $this->Form->postLink($plugin, array('action' => 'uninstall', $plugin)); ?>
		</li>
	<?php endforeach; ?>
	</ul>
</div>


<?php 
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Install',
		'items' => array(
			$this->Html->link(__('Dashboard'), '/admin'),
			)
		),
	))); ?>
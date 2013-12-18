<div class="webpage_csses index">
	<div class="list-group">
		<?php foreach ($webpageJses as $js) : ?>
			<div class="list-group-item">
				<?php echo $this->Html->link($js['WebpageJs']['name'], array('action' => 'edit', $js['WebpageJs']['id'])); ?>
				<span class="badge">Loaded, <?php echo !empty($js['WebpageJs']['is_requested']) ? 'Manually' : 'Automatically'; ?></span>
				<span class="badge">Template(s), <?php echo !empty($js['Webpage']['name']) ? $js['Webpage']['name'] : 'All'; ?></span>
			</div>
		<?php endforeach; ?>
	</div>
</div>
<?php
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Webpage Js',
		'items' => array(
			$this->Html->link(__('Add'), array('controller' => 'webpage_jses', 'action' => 'add')),
			)
		),
	)));
<div class="webpage_csses index">
	<div class="list-group">
		<?php foreach ($webpageCsses as $css) : ?>
			<div class="list-group-item">
				<?php echo $this->Html->link($css['WebpageCss']['name'], array('action' => 'edit', $css['WebpageCss']['id'])); ?>
				<span class="badge">Loaded, <?php echo !empty($css['WebpageCss']['is_requested']) ? 'Manually' : 'Automatically'; ?></span>
				<span class="badge">Template(s), <?php echo !empty($css['Webpage']['name']) ? $css['Webpage']['name'] : 'All'; ?></span>
			</div>
		<?php endforeach; ?>
	</div>
</div>
<?php
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Webpage Css',
		'items' => array(
			$this->Html->link(__('Add'), array('controller' => 'webpage_csses', 'action' => 'add')),
			)
		),
	)));
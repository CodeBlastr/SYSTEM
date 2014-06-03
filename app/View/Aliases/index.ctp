<?php echo $this->Paginator->link('Sort by Name', 'name'); ?>
<div class="list-group">
	<?php foreach ($aliases as $alias) : ?>
	<div class="list-group-item">
		<?php echo $this->Html->link('<span class="glyphicon glyphicon-edit">&nbsp;</span>', array('action' => 'edit', $alias['Alias']['id']), array('escape' => false)); ?>
		<?php echo $this->Html->link('http://' . $_SERVER['HTTP_HOST'] . '/' . $alias['Alias']['name'], '/' . $alias['Alias']['name']); ?>
		<span class="badge visible-lg"><?php echo !empty($alias['Alias']['plugin']) ? __('/%s', $alias['Alias']['plugin']) : null; ?><?php echo !empty($alias['Alias']['controller']) ? __('/%s', $alias['Alias']['controller']) : null; ?><?php echo !empty($alias['Alias']['action']) ? __('/%s', $alias['Alias']['action']) : null; ?><?php echo !empty($alias['Alias']['value']) ? __('/%s', $this->Text->truncate($alias['Alias']['value'], 10)) : null; ?></span>
	</div>
	<?php endforeach; ?>
</div>

<?php echo $this->element('paging'); ?>

<?php
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Aliases',
		'items' => array(
			$this->Html->link(__('Add'), array('controller' => 'aliases', 'action' => 'add')),
			)
		),
	)));
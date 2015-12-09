<?php echo $this->Paginator->link('Sort by Name', 'name'); ?>
<div class="list-group">
	<?php foreach ($aliases as $alias) : ?>
	<div class="list-group-item">
		<?php echo $this->Html->link('<span class="glyphicon glyphicon-edit">&nbsp;</span>', array('action' => 'edit', $alias['Alias']['id']), array('escape' => false)); ?>
		<?php echo $this->Html->link($_SERVER['HTTP_HOST'] . '/' . $alias['Alias']['name'], array('action' => 'edit', $alias['Alias']['id'])); ?>
		<?php echo $this->Html->link('<span class="glyphicon glyphicon-share-alt">&nbsp;</span>', '/' . $alias['Alias']['name'], array('escape' => false)); ?>
		<span class="badge visible-lg"><?php echo !empty($alias['Alias']['plugin']) ? __('/%s', $alias['Alias']['plugin']) : null; ?><?php echo !empty($alias['Alias']['controller']) ? __('/%s', $alias['Alias']['controller']) : null; ?><?php echo !empty($alias['Alias']['action']) ? __('/%s', $alias['Alias']['action']) : null; ?><?php echo !empty($alias['Alias']['value']) ? __('/%s', $this->Text->truncate($alias['Alias']['value'], 10)) : null; ?></span>
	</div>
	<?php endforeach; ?>
</div>

<?php echo $this->element('paging'); ?>

<?php
// set the contextual breadcrumb items
$this->set('context_crumbs', array(
	'crumbs' => array(
		$this->Html->link('Admin Dashboard', '/admin'),
		'Alias Dashboard'
		)
	));

// set contextual search options
$this->set('forms_search', array(
    'url' => '/admin/aliases/index/', 
	'inputs' => array(
		array(
			'name' => 'contains:name', 
			'options' => array(
				'label' => '', 
				'placeholder' => 'Type Your Search and Hit Enter',
				'value' => !empty($this->request->params['named']['contains']) ? substr($this->request->params['named']['contains'], strpos($this->request->params['named']['contains'], ':') + 1) : null,
				)
			),
		/*array(
			'name' => 'filter:contact_type', 
			'options' => array(
				'type' => 'select',
				'empty' => '-- All --',
				'options' => array(
					'lead' => 'Lead',
					'customer' => 'Customer',
					),
				'label' => '', 
				'placeholder' => 'Type Your Search and Hit Enter'
				)
			)*/
		)
	));
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Aliases',
		'items' => array(
			$this->Html->link(__('Add'), array('controller' => 'aliases', 'action' => 'add')),
			)
		),
	)));
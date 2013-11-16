<table class="table table-hover">
	<thead>
		<tr>
			<th>
				<?php echo $this->Paginator->sort('Setting.type', 'Type'); ?>
			</th>
			<th>
				<?php echo $this->Paginator->sort('Setting.displayName', 'Name'); ?>
			</th>
			<th>
				Actions
			</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach ($settings as $setting) : ?>
		<tr>
			<td>
				<?php echo $setting['Setting']['type']; ?>
			</td>
			<td>
				<?php echo $setting['Setting']['displayName']; ?>
			</td>
			<td>
				<?php echo $this->Html->link('Edit', array('action' => 'edit', $setting['Setting']['id']), array('class' => 'btn btn-xs btn-primary')); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>

<?php echo $this->element('paging'); ?>

<?php
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
			$this->Html->link(__('Add'), array('admin' => true, 'plugin' => null, 'controller' => 'settings', 'action' => 'add')),
			$this->Html->link(__('Test Mail'), array('admin' => true, 'plugin' => null, 'controller' => 'settings', 'action' => 'test')),
			)
		),
	))); ?>
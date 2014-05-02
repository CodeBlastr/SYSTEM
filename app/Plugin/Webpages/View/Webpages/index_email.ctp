<div class="webpages index list-group">
	<?php foreach ($webpages as $webpage) : ?>
		<div class="list-group-item clearfix">
			<div class="media">
				<div class="pull-left">
					<span class="glyphicon glyphicon-envelope" style="font-size: 115px; color: #ebebeb;"></span>
				</div>
				<div class="media-body">
					<h4>
						<?php echo $this->Html->link($webpage['Webpage']['title'], $webpage['Webpage']['_alias']); ?>
						<?php echo $this->Html->link('Edit', array('action' => 'edit', $webpage['Webpage']['id']), array('class' => 'btn btn-default btn-xs')); ?>
						<?php echo $this->Html->link('Delete', array('action' => 'delete', $webpage['Webpage']['id']), array('class' => 'btn btn-danger btn-xs pull-right')); ?>
					</h4>
					<p class="truncate">
						<?php echo strip_tags($webpage['Webpage']['content']); ?>
					</p>
					<p>
						<span class="label label-primary" title="Template Name"><span class="glyphicon glyphicon-pushpin"></span> <?php echo $webpage['Webpage']['name']; ?></span>
						<br />
						<span class="label label-info" title="ID Number"><span class="glyphicon glyphicon-qrcode"></span> <?php echo $webpage['Webpage']['id']; ?></span>
						<span class="label label-default" title="Created On"><span class="glyphicon glyphicon-time"></span> <?php echo ZuhaInflector::datify($webpage['Webpage']['created']); ?></span>
					</p>
				</div>
			</div>
		</div>
	<?php endforeach; ?>
	<?php if (empty($webpages)): ?>
	<p>No Email Templates have been created yet.  <?php echo $this->Html->link('Add one now', array('action' => 'add', 'email'), array('class' => 'btn btn-primary btn-large')); ?></p>
	<?php endif; ?>
	<?php echo $this->element('paging'); ?>
</div>


<?php
// set the contextual breadcrumb items
$this->set('context_crumbs', array('crumbs' => array(
	$this->Html->link(__('Admin Dashboard'), '/admin'),
	$page_title_for_layout,
)));

// set contextual search options
$this->set('forms_search', array(
    'url' => '/webpages/webpages/index/',
	'inputs' => array(
		array(
			'name' => 'contains:name',
			'options' => array(
				'label' => '',
				'placeholder' => 'Type Your Search and Hit Enter',
				'value' => !empty($this->request->params['named']['contains']) ? substr($this->request->params['named']['contains'], strpos($this->request->params['named']['contains'], ':') + 1) : null,
				)
			)
		)
	));

// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Content',
		'items' => array(
            $this->Html->link(__('Add Email Template'), array('controller' => 'webpages', 'action' => 'add', 'email')),
            ),
		),
	)));
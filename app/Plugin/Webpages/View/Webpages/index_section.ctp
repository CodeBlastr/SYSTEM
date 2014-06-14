<div class="webpages index">
	<h3>
		<?php echo $webpage['Webpage']['name']; ?>
		<?php echo $this->Html->link('View', array('action' => 'view', $webpage['Webpage']['id']), array('class' => 'btn btn-default btn-xs')); ?>
		<?php echo $this->Html->link('Edit', array('action' => 'edit', $webpage['Webpage']['id']), array('class' => 'btn btn-default btn-xs')); ?>
		<?php echo $this->Html->link('Add Sub Page', array('action' => 'add', 'sub', $webpage['Webpage']['id']), array('class' => 'btn btn-default btn-xs')); ?>
	</h3>
	<p>
		<span class="label label-primary"><span class="glyphicon glyphicon-qrcode"></span> <?php echo $webpage['Webpage']['id']; ?></span>
		<span class="label label-primary"><span class="glyphicon glyphicon-th"></span> <?php echo $webpage['Webpage']['type']; ?></span>
		<span class="label label-primary"><span class="glyphicon glyphicon-time"></span> <?php echo ZuhaInflector::datify($webpage['Webpage']['created']); ?></span>
	</p>
	<div class="list-group">
		<?php foreach ($webpages as $child) : ?>
		<div class="list-group-item clearfix">
			<div class="media">
				<?php echo $this->element('Galleries.thumb', array('thumbClass' => 'pull-left', 'model' => 'Webpage', 'foreignKey' => $child['Webpage']['id'])); ?>
				<div class="media-body">
					<h4>
						<?php echo $child['Webpage']['name']; ?>
						<?php echo $this->Html->link('View', $child['Webpage']['_alias'], array('class' => 'btn btn-default btn-xs')); ?>
						<?php echo $this->Html->link('Edit', array('action' => 'edit', $child['Webpage']['id']), array('class' => 'btn btn-default btn-xs')); ?>
						<?php echo $this->Html->link('<i class="glyphicon glyphicon-circle-arrow-up"></i>', array('action' => 'moveup', $child['Webpage']['id'], $this->Paginator->counter('{:count}')), array('title' => 'Move to Top', 'class' => 'btn btn-default btn-xs', 'escape' => false)); ?>
						<?php echo $this->Html->link('<i class="glyphicon glyphicon-chevron-up"></i>', array('action' => 'moveup', $child['Webpage']['id'], 1), array('title' => 'Move Up One Place', 'class' => 'btn btn-default btn-xs', 'escape' => false)); ?>
						<?php echo $this->Html->link('<i class="glyphicon glyphicon-chevron-down"></i>', array('action' => 'movedown', $child['Webpage']['id'], 1), array('title' => 'Move Down One Place', 'class' => 'btn btn-default btn-xs', 'escape' => false)); ?>
						<?php echo $this->Html->link('<i class="glyphicon glyphicon-circle-arrow-down"></i>', array('action' => 'movedown', $child['Webpage']['id'], $this->Paginator->counter('{:count}')), array('title' => 'Move to Bottom', 'class' => 'btn btn-default btn-xs', 'escape' => false)); ?>
					</h4>
					<p class="truncate">
						<?php echo strip_tags($child['Webpage']['content']); ?>
					</p>
					<p>
						<span class="label label-primary"><span class="glyphicon glyphicon-qrcode"></span> <?php echo $child['Webpage']['id']; ?></span>
						<span class="label label-primary"><span class="glyphicon glyphicon-th"></span> <?php echo $child['Webpage']['type']; ?></span>
						<span class="label label-primary"><span class="glyphicon glyphicon-time"></span> <?php echo ZuhaInflector::datify($child['Webpage']['created']); ?></span>
					</p>
				</div>
			</div>
		</div>
		<?php endforeach; ?>
	</div>
	<?php echo $this->element('paging'); ?>
</div>


<?php
// set the contextual breadcrumb items
$this->set('context_crumbs', array('crumbs' => array(
	$this->Html->link(__('Admin Dashboard'), '/admin'),
	$this->Html->link(__('All Pages'), array('action' => 'index', 'content')),
	$page_title_for_layout,
)));

// $items = '';
// foreach ($sections as $section) {
    // $items[] = $this->Html->link($section['Parent']['name'], array('plugin' => 'webpages', 'controller' => 'webpages', 'action' => 'index', 'sub', 'filter' => 'parent_id:' . $section['Parent']['id']));
// }

// $typeMenuItems = array();
// $typeMenuItems[] = $this->Html->link(__('Add Page Type'), array('controller' => 'enumerations', 'action' => 'add', 'WEBPAGES_PAGE_TYPE')); //Add Link

// foreach($page_types as $typeKey => $typeItem) {
	// $typeMenuItems[] = $this->Html->link(__('Add ' . $typeItem), array('controller' => 'webpages', 'action' => 'add', $typeKey)); 
// }

// set the contextual sorting items
//echo $this->Element('context_sort', array(
//    'context_sort' => array(
//        'type' => 'select',
//        'sorter' => array(array(
//            'heading' => '',
//            'items' => array(
//                $this->Paginator->sort('name'),
//                $this->Paginator->sort('created'),
//                )
//            )), 
//        )
//    )); 
  
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
		'heading' => 'Sections',
		'items' => array(
            $this->Html->link('Add Sub Page', array('action' => 'add', 'sub', $webpage['Webpage']['id']))
            ),
		),
	)));
<div class="webpages index list-group">
	<?php foreach ($webpages as $webpage) : ?>
		<div class="list-group-item clearfix">
			<div class="media">
				<?php //echo $this->element('Galleries.thumb', array('thumbClass' => 'pull-left', 'model' => 'Webpage', 'foreignKey' => $webpage['Webpage']['id'])); ?>
				<div class="media-body">
					<h4 data-id="<?php echo $webpage['Webpage']['id']; ?>">
						<?php echo $webpage['Webpage']['name']; ?>						
						<?php echo strpos($webpage['Webpage']['content'], '<?php') !== false ? null : $this->Html->link('Edit w/ WYSIWYG', array('admin' => true, 'action' => 'edit', $webpage['Webpage']['id']), array('class' => 'btn btn-default btn-success btn-xs')); ?>
						<?php echo $this->Html->link('Edit HTML', array('admin' => true, 'action' => 'edit', $webpage['Webpage']['id'], '?' => array('advanced' => 1)), array('class' => 'btn btn-default btn-warning btn-xs')); ?>
						<?php //strpos($webpage['Webpage']['content'], '<?php') !== false) ? ?>
					</h4>
						<?php //echo $this->Html->link('Add Sub Page', array('action' => 'add', 'sub', $webpage['Webpage']['id']), array('class' => 'btn btn-default btn-xs')); ?>
						<?php if (!empty($webpage['Child'][0])) : ?>
							<div class="btn-group">
								<?php echo $this->Html->link('Subpages', array('action' => 'index', 'section', $webpage['Webpage']['id']), array('class' => 'btn btn-default btn-xs')); ?>
								<button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
									<span class="caret"></span>
									<span class="sr-only">Toggle Dropdown</span>
								</button>
								<ul class="dropdown-menu" role="menu">
									<?php foreach ($webpage['Child'] as $child) : ?>
										<li>
											<?php echo $this->Html->link($child['name'], array('admin' => false, 'action' => 'view', $child['id'])); ?>
										</li>
									<?php endforeach; ?>
								</ul>
							</div>
						<?php endif; ?>
					<p>						
						<?php if (strpos($webpage['Webpage']['content'], '<?php') !== false) : ?>
						<span class="label label-warning"> Not WYSWIG Editable</span>  Template Tag : {element: <?php echo $webpage['Webpage']['name']; ?>}
						<?php else : ?>
						<span class="label label-success"> Inline Editing Capable</span> Template Tag : {page: <?php echo $webpage['Webpage']['name']; ?>}
						<?php endif; ?>
					</p>
				</div>
			</div>
		</div>
	<?php endforeach; ?>
	<?php echo $this->element('paging'); ?>
</div>


<?php
// set the contextual breadcrumb items
$this->set('context_crumbs', array('crumbs' => array(
	$this->Html->link(__('Admin Dashboard'), '/admin'),
	'Elements',
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
		'heading' => 'Webpages',
		'items' => array(
			$this->Paginator->sort('name'),
			$this->Html->link(__('Add'), array('controller' => 'webpages', 'action' => 'add', 'element')),
			)
		),
	)));
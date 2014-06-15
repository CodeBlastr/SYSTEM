<div class="webpages index list-group">
	<?php foreach ($webpages as $webpage) : ?>
		<div class="list-group-item clearfix">
			<div class="media">
				<?php echo $this->element('Galleries.thumb', array('thumbClass' => 'pull-left', 'model' => 'Webpage', 'foreignKey' => $webpage['Webpage']['id'])); ?>
				<div class="media-body">
					<h4>
						<?php echo $this->Html->link($webpage['Webpage']['name'], $webpage['Webpage']['_alias']); ?>
						<?php echo $this->Html->link('Edit', array('action' => 'edit', $webpage['Webpage']['id']), array('class' => 'btn btn-default btn-xs')); ?>
						<?php echo $this->Html->link('Add Sub Page', array('action' => 'add', 'sub', $webpage['Webpage']['id']), array('class' => 'btn btn-default btn-xs')); ?>
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
					</h4>
					<code><?php echo $webpage['Webpage']['_alias'] ?></code>
					<p class="truncate">
						<?php echo $this->Text->truncate(strip_tags($webpage['Webpage']['content'])); ?>
					</p>
					<p>
						<?php
						switch ($webpage['Webpage']['type']) {
							case 'section':
								$typeClass = 'info';
								break;
							case 'content':
								$typeClass = 'success';
								break;
							default:
								$typeClass = 'primary';
								break;
						}
						?>
						<span class="label label-primary"><span class="glyphicon glyphicon-qrcode"></span> <?php echo $webpage['Webpage']['id']; ?></span>
						<span class="label label-<?php echo $typeClass ?>"><span class="glyphicon glyphicon-th"></span> <?php echo $webpage['Webpage']['type']; ?></span>
						<span class="label label-default"><span class="glyphicon glyphicon-time"></span> <?php echo ZuhaInflector::datify($webpage['Webpage']['created']); ?></span>
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
    'url' => $this->request->admin == true ? '/admin/webpages/webpages/index' : '/webpages/webpages/index/', 
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
	// array(
		// 'heading' => 'Sections',
		// 'items' => $items,
		// ),
	array(
		'heading' => 'Sections',
		'items' => array(
            $this->Html->link(__('Add Page'), array('controller' => 'webpages', 'action' => 'add', 'content'))
            ),
		),
	// array(
		// 'heading' => 'Page Types',
		// 'items' => $typeMenuItems,
		// ),
	)));
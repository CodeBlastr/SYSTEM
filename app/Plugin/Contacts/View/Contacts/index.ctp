<div class="row">
	<div class="col-sm-8">
	<?php if (!empty($contacts)) : ?>
		<div class="list-group">
			<h3>Search results</h3>
			<?php foreach ($contacts as $contact) : ?>
				<div class="list-group-item clearfix">
					<div class="col-sm-6">
						<?php echo $this->Html->link($contact['Contact']['name'], array('action' => 'view', $contact['Contact']['id'])); ?>
					</div>
					<div class="col-sm-6 text-right">
						<span class="label label-default"><?php echo ZuhaInflector::datify($contact['Contact']['created']); ?></span>
						<?php echo $this->Html->link($contact['Assignee']['full_name'], array('action' => 'index', 'filter' => 'assignee_id:' . $contact['Assignee']['id']), array('class' => 'label label-default')); ?>
						<?php 
						if ($contact['Contact']['contact_rating'] == 'dead') : 
							$ratingLabel = 'danger';
						elseif ($contact['Contact']['contact_rating'] == 'active') : 
							$ratingLabel = 'info';
						elseif ($contact['Contact']['contact_rating'] == 'hot') : 
							$ratingLabel = 'success';
						else :
							$ratingLabel = 'default';
						endif; ?>
						<span class="label label-<?php echo $ratingLabel; ?>"><?php echo $contact['Contact']['contact_rating']; ?></span>
						<span class="label label-default"><?php echo $contact['Contact']['contact_type']; ?></span>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	<?php else : ?>
		<h1>No contacts found</h1>
	<?php endif; ?>
	</div>
	
	<div class="col-sm-4">
		<h3>Sort by</h3>
		<?php echo $this->Paginator->sort('name', 'Name', array('class' => 'btn btn-primary btn-xs')); ?>
		<?php echo $this->Paginator->sort('created', 'Created', array('class' => 'btn btn-primary btn-xs')); ?>
		<?php echo $this->Paginator->sort('assignee_id', 'Assignee', array('class' => 'btn btn-primary btn-xs')); ?>
		<?php echo $this->Paginator->sort('contact_rating', 'Rating', array('class' => 'btn btn-primary btn-xs')); ?>
		<h3>Filter by</h3>
		<?php echo $this->Html->link(__('Hot'), '/contacts/contacts/index/filter:is_company:1/filter:contact_rating:hot', array('class' => 'btn btn-primary btn-xs')); ?>
		<?php echo $this->Html->link(__('Warm'), '/contacts/contacts/index/filter:is_company:1/filter:contact_rating:warm', array('class' => 'btn btn-primary btn-xs')); ?>
		<?php echo $this->Html->link(__('Cold'), '/contacts/contacts/index/filter:is_company:1/filter:contact_rating:cold', array('class' => 'btn btn-primary btn-xs')); ?>
		<?php echo $this->Html->link(__('Active'), '/contacts/contacts/index/filter:is_company:1/filter:contact_rating:active', array('class' => 'btn btn-primary btn-xs')); ?>
		<?php echo $this->Html->link(__('Dead'), '/contacts/contacts/index/filter:is_company:1/filter:contact_rating:dead', array('class' => 'btn btn-primary btn-xs')); ?>
		<hr />
		<?php echo $this->Html->link(__('All'), array('plugin' => 'contacts', 'controller'=> 'contacts', 'action' => 'index'), array('class' => 'btn btn-primary btn-xs')); ?>
		<?php echo $this->Html->link(__('Lead'), '/contacts/contacts/index/filter:is_company:1/filter:contact_type:lead', array('class' => 'btn btn-primary btn-xs')); ?>
		<?php echo $this->Html->link(__('Customer'), '/contacts/contacts/index/filter:is_company:1/filter:contact_type:customer', array('class' => 'btn btn-primary btn-xs')); ?>
		<?php echo $this->Html->link(__('Vendor'), '/contacts/contacts/index/filter:is_company:1/filter:contact_type:vendor', array('class' => 'btn btn-primary btn-xs')); ?>
      
		<?php
		// echo $this->element('context_sort', array(
		   // 'context_sort' => array(
		       // 'type' => 'select',
		       // 'sorter' => array(array(
		           // 'heading' => '',
		           // 'items' => array(
		               // $this->Paginator->sort('name'),
		               // $this->Paginator->sort('created'),
		               // )
		           // )), 
		       // )
		   // )); ?>
	</div>
</div>
 
<?php echo $this->element('paging'); ?>

<?php
// set contextual search options
$this->set('forms_search', array(
    'url' => '/contacts/contacts/index/', 
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
    
// set the contextual breadcrumb items
$this->set('context_crumbs', array('crumbs' => array(
	$this->Html->link(__('Dashboard'), array('action' => 'dashboard')),
	'Contact Search'
)));

// set the contextual menu items
$this->set('context_menu', array('menus' => array(
  array(
    'heading' => '',
    'items' => array(
      $this->Html->link(__('Dashboard'), array('plugin' => 'contacts', 'controller'=> 'contacts', 'action' => 'dashboard')),
      ),
    ),
  array(
    'heading' => '',
    'items' => array(
      $this->Html->link(__('Companies'), '/contacts/contacts/index/filter:is_company:1/filter:contact_type:customer'),
      $this->Html->link(__('People'), '/contacts/contacts/index/filter:is_company:0'),
      ),
    ),
  array(
    'heading' => '',
    'items' => array(
      $this->Html->link(__('Add'), array('plugin' => 'contacts', 'controller'=> 'contacts', 'action' => 'add')),
      ),
    ),
  ))); ?>
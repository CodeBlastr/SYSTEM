<?php if (!empty($tasks)) : ?>
	<div class="list-group">
		<?php foreach ($tasks as $task) : ?>
			<div class="list-group-item media clearfix">
				<?php echo $this->Html->link($this->element('Galleries.thumb', array('model' => 'User', 'foreignKey' => $task['Task']['assignee_id'], 'thumbClass' => 'img-thumbnail media-object', 'thumbWidth' => 36, 'thumbHeight' => 36)), array('plugin' => 'users', 'controller' => 'users', 'action' => 'view', $person['User']['id']), array('class' => 'pull-left', 'escape' => false)); // hard coded sizes used on mega buildrr ?>
				<div class="media-body pull-left">
					<h5 class="media-heading"><?php echo $this->Html->link($task['Task']['name'], array('action' => 'task', $task['Task']['id'])); ?></h5>
				</div>
				<?php echo $this->Html->link('Edit', array('plugin' => 'tasks', 'controller' => 'tasks', 'action' => 'edit', $task['Task']['id']), array('class' => 'badge')); ?>
				<?php echo $this->Html->link('Complete', array('plugin' => 'tasks', 'controller' => 'tasks', 'action' => 'complete', $task['Task']['id']), array('class' => 'badge')); ?>
			</div>
		<?php endforeach; ?>
	</div>
<?php else : ?>
	<div class="col-md-12">
		<h2>No tasks found</h2>
	</div>
<?php endif; ?>
				
<?php
// set forms search options
$this->set('formsSearch', array(
	'url' => '/contacts/contacts/tasks/',
	'inputs' => array( array(
			'name' => 'contains:name',
			'options' => array(
				'label' => '',
				'placeholder' => 'Type Your Search and Hit Enter',
				'value' => !empty($this->request->params['named']['contains']) ? substr($this->request->params['named']['contains'], strpos($this->request->params['named']['contains'], ':') + 1) : null,
			)
		))
	));
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
		array(
			'heading' => '',
			'items' => array($this->Html->link(__('Dashboard'), array(
					'plugin' => 'contacts',
					'controller' => 'contacts',
					'action' => 'dashboard'
				)), ),
		),
		array(
			'heading' => '',
			'items' => array(
				$this->Html->link(__('All'), array(
					'plugin' => 'contacts',
					'controller' => 'contacts',
					'action' => 'index'
				)),
				$this->Html->link(__('Leads'), array(
					'plugin' => 'contacts',
					'controller' => 'contacts',
					'action' => 'index',
					'filter' => 'contact_type:lead'
				)),
				$this->Html->link(__('Companies'), array(
					'plugin' => 'contacts',
					'controller' => 'contacts',
					'action' => 'index',
					'filter' => 'is_company:1/filter:contact_type:customer'
				)),
				$this->Html->link(__('People'), array(
					'plugin' => 'contacts',
					'controller' => 'contacts',
					'action' => 'index',
					'filter' => 'is_company:0/filter:contact_type:customer'
				)),
			),
		),
		array(
			'heading' => '',
			'items' => array($this->Html->link(__('Add'), array(
					'plugin' => 'contacts',
					'controller' => 'contacts',
					'action' => 'add'
				)))
		)
	)));

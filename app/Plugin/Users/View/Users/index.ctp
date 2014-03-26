<div class="list-group">
	<?php foreach ($users as $user) : ?>
		<div class="list-group-item clearfix">
			<div class="media">
				<?php echo $this->element('Galleries.thumb', array('model' => 'User', 'foreignKey' => $user['User']['id'], 'thumbClass' => 'pull-left')); ?>
				<div class="media-body col-md-8">
					<?php echo $this->Html->link($user['User']['full_name'], array('action' => 'view', $user['User']['id'])); ?>
				</div>
			</div>
			<span class="badge">Since : <?php echo ZuhaInflector::datify($user['User']['created']); ?></span>
			<span class="badge"><?php echo $user['UserRole']['name']; ?></span>
		</div>
	<?php endforeach; ?>
</div>

<?php echo $this->element('paging'); ?>

<?php    
// set contextual search options
$this->set('forms_search', array(
    'url' => '/users/users/index/', 
	'inputs' => array(
		array(
			'name' => 'contains:full_name', 
			'options' => array(
				'label' => '', 
				'placeholder' => 'Search Users',
				'value' => !empty($this->request->params['named']['contains']) ? substr($this->request->params['named']['contains'], strpos($this->request->params['named']['contains'], ':') + 1) : null,
				)
			),
		)
	));
	
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Users',
		'items' => array(
			 $this->Html->link(__('New User', true), array('action' => 'procreate')),
			 )
		),
	array(
		'heading' => 'User Roles',
		'items' => array(
			 $this->Html->link(__('User Roles', true), array('controller' => 'user_roles', 'action' => 'index')),
			 )
		),
	)));?>

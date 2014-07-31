<div class="privileges index row">
	<div class="span3 col-md-3 bs-docs-sidebar">
		<ul class="list-group bs-docs-sidenav">
		<?php foreach ($sections as $section) : ?>
			<li class="list-group-item dropdown">
			<?php if (!empty($section['children'][0]['children'])) : ?>
				<?php echo $this->Html->link(
						__('<i class="glyphicon glyphicon-chevron-rightt"></i> %s', $section['Section']['alias']), 
						'#' . $section['Section']['alias'], 
						array('escape' => false, 'data-toggle' => 'collapse', 'data-target' => '#' . $section['Section']['alias']));
				?> 
				<ul id="<?php echo $section['Section']['alias']; ?>" class="collapse">
				<?php foreach ($section['children'] as $child) : ?>
					<li>
					<?php echo $this->Js->link(
							Inflector::singularize(Inflector::humanize(Inflector::underscore($child['Section']['alias']))), 
							array(
								'plugin' => 'privileges',
								'controller' => 'sections',
								'action' => 'loadElement',
								$child['Section']['alias']
							),
							array(
								'update' => '#privilegesTables',
								'method' => 'post',
								'data' => 'json=' . serialize(array(
										'sdata' => $child['children'],
										'userFields' => $section['userFields']
									)),
								//'complete' => 'applyCheckboxToggles();$("#privilegesTables").fadeIn();',
								'complete' => '$("#privilegesTables").fadeIn();$(".privileges.index .make-switch").bootstrapSwitch()',
								'before' => '$("#privilegesTables").fadeOut();'
							)
						); ?>
					</li>
				<?php endforeach; ?>
				</ul>
			<?php else : ?>
					<?php
					echo $this->Js->link('<i class="icon-chevron-right"></i> ' . Inflector::humanize(Inflector::underscore($section['Section']['alias'])), array(
						'plugin' => 'privileges',
						'controller' => 'sections',
						'action' => 'loadElement',
						$section['Section']['alias']
					), array(
						'update' => '#privilegesTables',
						'method' => 'post',
						'data' => 'json=' . serialize(array(
							'sdata' => $section['children'],
							'userFields' => $section['userFields']
						)),
						//'complete' => 'applyCheckboxToggles();$("#privilegesTables").fadeIn();',
						'complete' => '$("#privilegesTables").fadeIn();$(".privileges.index .make-switch").bootstrapSwitch()',
						'before' => '$("#privilegesTables").fadeOut();',
						'escape' => false
					)); ?>
			<?php endif; ?>
		</li>
	<?php endforeach; ?>
	</ul>
	</div>

	<div class="span9 col-md-9">
		<p>
			Each section listed below contains rows of <a rel="tooltip" title="Things like view, add, edit, delete.  Typically they correspond to an actual page url you can visit.">Actions</a> that a user can take with columns of what the <a rel="tooltip" title="Groups that you put users into to control their access to actions.">User Roles</a> are.  To give a User Role access to an action, simply click the check box under the role, and then the save button at the bottom of that section. By default all actions are restricted to admins, and must be purposely granted.
		</p>
		<div id="privilegesTables"></div>
	</div>
</div>

<script type="text/javascript">
	$(function() {
		$('a[data-toggle=collapse]').click(function(e) {
			e.preventDefault();
		});
	});
</script>

<?php
echo $this->Js->writeBuffer();

// set the contextual breadcrumb items
$this->set('context_crumbs', array('crumbs' => array(
	$this->Html->link(__('Admin Dashboard'), '/admin'),
	$this->Html->link('User Dashboard', array('plugin' => 'users', 'controller' => 'users', 'action' => 'dashboard')),
	$this->Html->link('User Roles', array('plugin' => 'users', 'controller' => 'user_roles', 'action' => 'index')),
	'Privileges',
)));
// set the contextual menu items
$this->set('context_menu', array('menus' => array( array(
			'heading' => 'Privileges',
			'items' => array(
				$this->Html->link(__('Sync Sections'), array(
					'controller' => 'sections',
					'action' => 'clear_session'
				)),
				$this->Html->link(__('User Roles'), array(
					'plugin' => 'users',
					'controller' => 'user_roles',
					'action' => 'index'
				)),
			)
		))));

<?php echo $this->Form->create('Alias'); ?>
	<div class="row">
		<div class="col-sm-6">
			<h3>Permanent Url</h3>
			<?php echo $this->Form->input('Alias.name', array('label' => 'Address <small>eg. about-us</small>')); ?>
			<?php echo $this->Form->input('Alias.plugin'); ?>
			<?php echo $this->Form->input('Alias.controller'); ?>
			<?php echo $this->Form->input('Alias.action'); ?>
			<?php echo $this->Form->input('Alias.value'); ?>
		</div>
		<div class="col-sm-6">
			<h3>SEO</h3>
			<?php echo $this->Form->input('Alias.title', array('SEO Title', 'type' => 'text')); ?>
			<?php echo $this->Form->input('Alias.keywords', array('SEO Keywords')); ?>
			<?php echo $this->Form->input('Alias.description', array('SEO Description')); ?>
			<?php echo $this->Form->input('Alias.in_sitemap'); ?>
		</div>
	</div>
<?php echo $this->Form->end('Save'); ?>

<?php
// set the contextual breadcrumb items
$this->set('context_crumbs', array(
	'crumbs' => array(
		$this->Html->link('Admin Dashboard', '/admin'),
		$this->Html->link('Alias Dashboard', array('action' => 'index')),
		'Add Permanent URL Alias'
		)
	));

// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Aliases',
		'items' => array(
			$this->Html->link(__('List'), array('controller' => 'aliases', 'action' => 'index')),
			)
		),
	)));
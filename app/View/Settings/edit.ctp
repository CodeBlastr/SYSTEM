<div class="settings form row">
	<div class="col-sm-7">
		<?php echo $this->Form->create('Setting'); ?>
		<fieldset>
	 		<legend><?php echo __('Edit Setting'); ?></legend>
			<?php echo $this->Form->input('Setting.id'); ?>
			<?php echo $this->Form->input('Setting.type'); ?>
			<?php echo $this->Form->input('Setting.name'); ?>
			<?php echo $this->Form->input('Setting.value'); ?>
			<?php echo $this->Form->end('Submit'); ?>
		</fieldset>
	</div>
	<div class="col-sm-5">
		<h4>Description</h4>
		<p class="well well-lg"><?php echo nl2br($this->Form->value('Setting.description')); ?></p>
	</div>
</div>

<?php
// set the contextual breadcrumb items
$this->set('context_crumbs', array('crumbs' => array(
	$this->Html->link(__('Admin Dashboard'), '/admin'),
	$page_title_for_layout,
)));

// set the contextual menu items
$this->set('context_menu', array('menus' => array( array(
			'heading' => 'Settings',
			'items' => array(
				$this->Html->link(__('List'), array('action' => 'index')),
				$this->Html->link(__('Add'), array('action' => 'add')),
				$this->Html->link(__('Delete'), array('action' => 'delete', $this->Form->value('Setting.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Setting.id')))
			)
		))));

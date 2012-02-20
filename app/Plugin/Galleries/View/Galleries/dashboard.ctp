<div class="galleries dashboard">
	<h2><?php echo __('Galleries Dashboard'); ?></h2>

	<?php
	if(!empty($instance) && defined('__GALLERIES_SETTINGS_'.$instance)) {
		$values = unserialize(constant('__GALLERIES_SETTINGS_'.$instance));
	} else if (defined('__GALLERIES_SETTINGS')) {
		$values = unserialize(__GALLERIES_SETTINGS);
	} ?>

    <?php echo $this->Element('settings/edit', array('type' => 'Galleries', 'name' => 'SETTINGS')); ?>

    <div class="galleries index">
    	<h3><?php echo __('Galleries List'); ?></h3>
	<?php
	echo $this->Element('scaffolds/index', array(
		'data' => $galleries,
		'actions' => array(
			$this->Html->link('View', array('action' => 'view', '{model}', '{foreign_key}')),
			$this->Html->link('Edit', array('action' => 'edit', '{model}', '{foreign_key}')),
			$this->Html->link('Delete', array('action' => 'delete', '{id}'), array(), 'Are you sure you want to permanently delete?'),
			),
		)); ?>
	</div>
</div>
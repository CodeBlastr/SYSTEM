<div class="menus form">
<?php echo $this->Form->create('WebpagMenu');?>
	<fieldset>
 		<legend><?php echo __('Edit Menu'); ?></legend>
	    <?php
    	echo $this->Form->input('WebpageMenu.id');
		echo $this->Form->input('WebpageMenu.name');
		echo $this->Form->input('WebpageMenu.type', array('empty' => '-- Optional --')); ?>
    </fieldset>
    <fieldset>
    	<legend class="toggleClick"><?php echo __('Advanced'); ?></legend>
	    <?php
		echo $this->Form->input('WebpageMenu.params');
		echo $this->Form->input('WebpageMenu.css_id', array('type' => 'text', 'label' => 'Css Id'));
		echo $this->Form->input('WebpageMenu.css_class');
		echo $this->Form->input('WebpageMenu.order'); ?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<?php 
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Menus',
		'items' => array(
			$this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('WebpageMenu.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('WebpageMenu.id'))),
			$this->Html->link(__('List', true), array('action' => 'index')),
			$this->Html->link(__('Add Menu Item', true), array('controller' => 'webpage_menu_items', 'action' => 'add', $this->Form->value('WebpageMenu.id'))),
			)
		),
	))); ?>
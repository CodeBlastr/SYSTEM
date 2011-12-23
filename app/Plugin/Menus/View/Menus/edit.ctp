<div class="menus form">
<?php echo $this->Form->create('Menu');?>
	<fieldset>
 		<legend><?php echo __('Edit Menu'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('type', array('empty' => true));
	?>
    </fieldset>
    <fieldset>
    	<legend><?php echo __('Advanced'); ?></legend>
	<?php
		echo $this->Form->input('params');
		echo $this->Form->input('css_id', array('type' => 'text', 'label' => 'Css Id'));
		echo $this->Form->input('css_class');
		echo $this->Form->input('order');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<?php 
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Menus',
		'items' => array(
			$this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Menu.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Menu.id'))),
			$this->Html->link(__('List Menus', true), array('action' => 'index')),
			$this->Html->link(__('New Menu Item', true), array('controller' => 'menu_items', 'action' => 'add', $this->Form->value('Menu.id'))),
			)
		),
	)));
?>
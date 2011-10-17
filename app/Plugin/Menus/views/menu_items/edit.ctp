<div class="menus form">
<?php echo $this->Form->create('MenuItem');?>
	<fieldset>
 		<legend><?php __('Item Location'); ?></legend>
	<?php
		echo $this->Form->input('menu_id');
		echo $this->Form->input('parent_id', array('empty' => true));
	?>
    </fieldset>
	<fieldset>
 		<legend><?php __('Item Detail'); ?></legend>
	<?php
		echo $this->Form->input('item_text', array('label' => 'Link Text'));
		echo $this->Form->input('item_url', array('label' => 'Url'));
		echo $this->Form->input('order');
	?>
    </fieldset>
	<fieldset>
 		<legend><?php __('Advanced'); ?></legend>
	<?php
		echo $this->Form->input('item_before', array('label' => 'Before'));
		echo $this->Form->input('item_after', array('label' => 'After'));
		echo $this->Form->input('item_css_class', array('label' => 'Css Class'));
		echo $this->Form->input('item_css_id', array('type' => 'text', 'label' => 'Css Id'));
		echo $this->Form->input('item_target', array('label' => 'Target', 'empty' => true));
		echo $this->Form->input('item_title', array('label' => 'Title'));
		echo $this->Form->input('item_attributes', array('label' => 'Attributes'));
		echo $this->Form->input('item_auto_authorize', array('label' => 'Auto Authorize?'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('MenuItem.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Menu.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Menus', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Menus', true), array('controller' => 'menus', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Parent Menu', true), array('controller' => 'menus', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Creator', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
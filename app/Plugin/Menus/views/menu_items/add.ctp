<div class="menus form">
<?php echo $this->Form->create('MenuItem');?>
	<fieldset>
 		<legend><?php echo __('Item Location'); ?></legend>
	<?php
		echo !empty($menuId) ? $this->Form->input('menu_id', array('type' => 'hidden', 'value' => $menuId)) : $this->Form->input('menu_id');
		echo $this->Form->input('parent_id', array('empty' => true));
	?>
    </fieldset>
	<fieldset>
 		<legend><?php echo __('Item Detail'); ?></legend>
	<?php
		echo $this->Form->input('item_text', array('label' => 'Link Text'));
		echo $this->Form->input('item_url', array('label' => 'Url'));
		echo $this->Form->input('order');
	?>
    </fieldset>
	<fieldset>
 		<legend><?php echo __('Advanced'); ?></legend>
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
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Menus', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Menus', true), array('controller' => 'menus', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Parent Menu', true), array('controller' => 'menus', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Creator', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="menus form">
<?php echo $this->Form->create('Menu');?>
	<fieldset>
 		<legend><?php echo __('Add Menu'); ?></legend>
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
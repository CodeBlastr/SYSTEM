<div class="conditions view">
<h2><?php  __('Condition');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $condition['Condition']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $condition['Condition']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Description'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $condition['Condition']['description']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Plugin'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $condition['Condition']['plugin']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Controller'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $condition['Condition']['controller']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Action'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $condition['Condition']['action']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Condition'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $condition['Condition']['condition']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Model'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $condition['Condition']['model']; ?>
			&nbsp;
		</dd>
	</dl>
</div>

<?php 
// set the contextual menu items
$this->Menu->setValue(array(
	array(
		'heading' => 'Conditions',
		'items' => array(
			$this->Html->link(__('Edit Condition', true), array('plugin' => null, 'controller' => 'conditions', 'action' => 'edit', $condition['Condition']['id'])),
			$this->Html->link(__('Delete Condition', true), array('plugin' => null, 'controller' => 'conditions', 'action' => 'delete', $condition['Condition']['id'])),
			$this->Html->link(__('List Conditions', true), array('plugin' => null, 'controller' => 'conditions', 'action' => 'index')),
			$this->Html->link(__('New Condition', true), array('plugin' => null, 'controller' => 'conditions', 'action' => 'edit')),
			)
		),
	)
);
?>
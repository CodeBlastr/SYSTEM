<div class="conditions index">
<h2><?php echo __('Conditions');?></h2>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $this->Paginator->sort('id');?></th>
	<th><?php echo $this->Paginator->sort('name');?></th>
	<th><?php echo $this->Paginator->sort('is_create');?></th>
	<th><?php echo $this->Paginator->sort('is_read');?></th>
	<th><?php echo $this->Paginator->sort('is_update');?></th>
	<th><?php echo $this->Paginator->sort('is_delete');?></th>
	<th><?php echo $this->Paginator->sort('model');?></th>
	<th class="actions"><?php echo __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($conditions as $condition):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $condition['Condition']['id']; ?>
		</td>
		<td>
			<?php echo $condition['Condition']['name']; ?>
		</td>
		<td>
			<?php echo $condition['Condition']['is_create']; ?>
		</td>
		<td>
			<?php echo $condition['Condition']['is_read']; ?>
		</td>
		<td>
			<?php echo $condition['Condition']['is_update']; ?>
		</td>
		<td>
			<?php echo $condition['Condition']['is_delete']; ?>
		</td>
		<td>
			<?php echo $condition['Condition']['model']; ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $condition['Condition']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $condition['Condition']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $condition['Condition']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $condition['Condition']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<?php echo $this->Element('paging'); ?>

<?php 
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Conditions',
		'items' => array(
			$this->Html->link(__('New Condition', true), array('plugin' => null, 'controller' => 'conditions', 'action' => 'edit')),
			)
		),
	)));
?>

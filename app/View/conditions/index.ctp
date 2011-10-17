<div class="conditions index">
<h2><?php __('Conditions');?></h2>
<p>
<?php
echo $this->Paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $this->Paginator->sort('id');?></th>
	<th><?php echo $this->Paginator->sort('name');?></th>
	<th><?php echo $this->Paginator->sort('is_create');?></th>
	<th><?php echo $this->Paginator->sort('is_read');?></th>
	<th><?php echo $this->Paginator->sort('is_update');?></th>
	<th><?php echo $this->Paginator->sort('is_delete');?></th>
	<th><?php echo $this->Paginator->sort('model');?></th>
	<th class="actions"><?php __('Actions');?></th>
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
<div class="paging">
	<?php echo $this->Paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $this->Paginator->numbers();?>
	<?php echo $this->Paginator->next(__('next', true).' >>', array(), null, array('class' => 'disabled'));?>
</div>

<?php 
// set the contextual menu items
$this->Menu->setValue(array(
	array(
		'heading' => 'Conditions',
		'items' => array(
			$this->Html->link(__('New Condition', true), array('plugin' => null, 'controller' => 'conditions', 'action' => 'edit')),
			)
		),
	)
);
?>

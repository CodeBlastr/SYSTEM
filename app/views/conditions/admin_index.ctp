<div class="conditions index">
<h2><?php __('Conditions');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort('name');?></th>
	<th><?php echo $paginator->sort('plugin');?></th>
	<th><?php echo $paginator->sort('controller');?></th>
	<th><?php echo $paginator->sort('action');?></th>
	<th><?php echo $paginator->sort('condition');?></th>
	<th><?php echo $paginator->sort('model');?></th>
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
			<?php echo $condition['Condition']['plugin']; ?>
		</td>
		<td>
			<?php echo $condition['Condition']['controller']; ?>
		</td>
		<td>
			<?php echo $condition['Condition']['action']; ?>
		</td>
		<td>
			<?php echo $condition['Condition']['condition']; ?>
		</td>
		<td>
			<?php echo $condition['Condition']['model']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action' => 'view', $condition['Condition']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action' => 'edit', $condition['Condition']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action' => 'delete', $condition['Condition']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $condition['Condition']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<div class="paging">
	<?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('next', true).' >>', array(), null, array('class' => 'disabled'));?>
</div>

<?php 
// set the contextual menu items
$menu->setValue(array(
	array(
		'heading' => 'Conditions',
		'items' => array(
			$html->link(__('New Condition', true), array('plugin' => null, 'controller' => 'conditions', 'action' => 'edit')),
			)
		),
	)
);
?>

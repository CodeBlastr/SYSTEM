<div class="attributes index">
<h2><?php __('French Localized Attributes');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort('code');?></th>
	<th><?php echo $paginator->sort('name');?></th>
	<th><?php echo $paginator->sort('is_required');?></th>
	<th><?php echo $paginator->sort('is_system');?></th>
	<th><?php echo $paginator->sort('is_visible');?></th>
	<th><?php echo $paginator->sort('is_advancedsearch');?></th>
	<th><?php echo $paginator->sort('is_layered');?></th>
	<th><?php echo $paginator->sort('is_comparable');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($attributes as $attribute):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $attribute['Attribute']['id']; ?>
		</td>
		<td>
			<?php echo $attribute['Attribute']['code']; ?>
		</td>
		<td>
			<?php echo $attribute['Attribute']['name']; ?>
		</td>
		<td>
			<?php echo $attribute['Attribute']['is_required']; ?>
		</td>
		<td>
			<?php echo $attribute['Attribute']['is_system']; ?>
		</td>
		<td>
			<?php echo $attribute['Attribute']['is_visible']; ?>
		</td>
		<td>
			<?php echo $attribute['Attribute']['is_advancedsearch']; ?>
		</td>
		<td>
			<?php echo $attribute['Attribute']['is_layered']; ?>
		</td>
		<td>
			<?php echo $attribute['Attribute']['is_comparable']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('Edit', true), array('action' => 'edit', $attribute['Attribute']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action' => 'delete', $attribute['Attribute']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $attribute['Attribute']['id'])); ?>
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
		'heading' => 'Attributes',
		'items' => array(
			$html->link(__('New Attribute', true), array('action' => 'edit')),
			)
		),
	array(
		'heading' => 'Attribute Groups',
		'items' => array(
			$html->link(__('New AttributeGroup', true), array('controller' => 'attribute_groups', 'action' => 'edit')),
			$html->link(__('List AttributeGroups', true), array('controller' => 'attribute_groups', 'action' => 'index')),
			)
		),
	)
);
?>

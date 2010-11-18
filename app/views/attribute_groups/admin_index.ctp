<div class="attributeGroups index">
<h2><?php __('Attribute Groups');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort('enumeration_id');?></th>
	<th><?php echo $paginator->sort('name');?></th>
	<th><?php echo $paginator->sort('model');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($attributeGroups as $attributeGroup):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $attributeGroup['AttributeGroup']['id']; ?>
		</td>
		<td>
			<?php echo $attributeGroup['Enumeration']['type']. ' : ' .$attributeGroup['Enumeration']['name']; ?>
		</td>
		<td>
			<?php echo $attributeGroup['AttributeGroup']['name']; ?>
		</td>
		<td>
			<?php echo $attributeGroup['AttributeGroup']['model']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('Edit', true), array('action' => 'edit', $attributeGroup['AttributeGroup']['id'])); ?>
			<?php echo $html->link(__('View Attributes', true), array('controller' => 'attributes', 'action' => 'index', 'group' => $attributeGroup['AttributeGroup']['id'], 'system' => 1)); ?>
			<?php echo $html->link(__('Delete', true), array('action' => 'delete', $attributeGroup['AttributeGroup']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $attributeGroup['AttributeGroup']['id'])); ?>
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
		'heading' => 'Attribute Groups',
		'items' => array(
			$html->link(__('New Attribute Group', true), array('action' => 'edit')),
			$html->link(__('Show System Groups', true), array('action' => 'index', 'system' => 1)),
			)
		),
	array(
		'heading' => 'Attributes',
		'items' => array(
			$html->link(__('New Attributes', true), array('controller' => 'attributes', 'action' => 'add')),
			$html->link(__('List Attributes', true), array('controller' => 'attributes', 'action' => 'index')),
			)
		),
	)
);
?>

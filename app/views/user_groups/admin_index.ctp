<div class="userGroups index">
<h2><?php __('UserGroups');?></h2>
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
	<th><?php echo $paginator->sort('created');?></th>
	<th><?php echo $paginator->sort('modified');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($userGroups as $userGroup):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $userGroup['UserGroup']['id']; ?>
		</td>
		<td>
			<?php echo $userGroup['UserGroup']['name']; ?>
		</td>
		<td>
			<?php echo $userGroup['UserGroup']['created']; ?>
		</td>
		<td>
			<?php echo $userGroup['UserGroup']['modified']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action' => 'view', $userGroup['UserGroup']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action' => 'edit', $userGroup['UserGroup']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action' => 'delete', $userGroup['UserGroup']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $userGroup['UserGroup']['id'])); ?>
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
		'heading' => 'User Groups',
		'items' => array(
			 $html->link(__('Add User Group', true), array('action' => 'add')),
			 )
		),
	array(
		'heading' => 'Users',
		'items' => array(
			 $html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')),
			 )
		),
	));
?>

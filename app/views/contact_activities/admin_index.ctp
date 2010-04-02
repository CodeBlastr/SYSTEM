<div class="contactActivities index">
<h2><?php __('ContactActivities');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort('parent_id');?></th>
	<th><?php echo $paginator->sort('contact_activity_type_id');?></th>
	<th><?php echo $paginator->sort('name');?></th>
	<th><?php echo $paginator->sort('description');?></th>
	<th><?php echo $paginator->sort('contact_id');?></th>
	<th><?php echo $paginator->sort('creator_id');?></th>
	<th><?php echo $paginator->sort('modifier_id');?></th>
	<th><?php echo $paginator->sort('created');?></th>
	<th><?php echo $paginator->sort('modified');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($contactActivities as $contactActivity):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $contactActivity['ContactActivity']['id']; ?>
		</td>
		<td>
			<?php echo $html->link($contactActivity['ContactActivityParent']['name'], array('controller' => 'contact_activities', 'action' => 'view', $contactActivity['ContactActivityParent']['id'])); ?>
		</td>
		<td>
			<?php echo $html->link($contactActivity['ContactActivityType']['name'], array('controller' => 'contact_activity_types', 'action' => 'view', $contactActivity['ContactActivityType']['id'])); ?>
		</td>
		<td>
			<?php echo $contactActivity['ContactActivity']['name']; ?>
		</td>
		<td>
			<?php echo $contactActivity['ContactActivity']['description']; ?>
		</td>
		<td>
			<?php echo $html->link($contactActivity['Contact']['id'], array('controller' => 'contacts', 'action' => 'view', $contactActivity['Contact']['id'])); ?>
		</td>
		<td>
			<?php echo $html->link($contactActivity['Creator']['id'], array('controller' => 'users', 'action' => 'view', $contactActivity['Creator']['id'])); ?>
		</td>
		<td>
			<?php echo $html->link($contactActivity['Modifier']['id'], array('controller' => 'users', 'action' => 'view', $contactActivity['Modifier']['id'])); ?>
		</td>
		<td>
			<?php echo $contactActivity['ContactActivity']['created']; ?>
		</td>
		<td>
			<?php echo $contactActivity['ContactActivity']['modified']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action' => 'view', $contactActivity['ContactActivity']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action' => 'edit', $contactActivity['ContactActivity']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action' => 'delete', $contactActivity['ContactActivity']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $contactActivity['ContactActivity']['id'])); ?>
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
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('New ContactActivity', true), array('action' => 'add')); ?></li>
		<li><?php echo $html->link(__('List Contact Activities', true), array('controller' => 'contact_activities', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Contact Activity Parent', true), array('controller' => 'contact_activities', 'action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('List Contact Activity Types', true), array('controller' => 'contact_activity_types', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Contact Activity Type', true), array('controller' => 'contact_activity_types', 'action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Creator', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('List Contacts', true), array('controller' => 'contacts', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Contact', true), array('controller' => 'contacts', 'action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('List Contact Activity Media', true), array('controller' => 'contact_activity_media', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Contact Activity Medium', true), array('controller' => 'contact_activity_media', 'action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('List Contact Activity User Groups', true), array('controller' => 'contact_activity_user_groups', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Contact Activity User Group', true), array('controller' => 'contact_activity_user_groups', 'action' => 'add')); ?> </li>
	</ul>
</div>

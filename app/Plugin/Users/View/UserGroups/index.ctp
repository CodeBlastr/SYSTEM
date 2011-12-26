<div class="userGroups index">
	<h2><?php echo __('User Groups');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('title');?></th>
			<th><?php echo $this->Paginator->sort('description');?></th>
			<th><?php echo $this->Paginator->sort('creator_id');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
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
		<td><?php echo $userGroup['UserGroup']['id']; ?>&nbsp;</td>
		<td><?php echo $this->Html->link($userGroup['UserGroup']['title'], array('plugin'=>'users','controller'=>'user_groups' , 'action'=>'view' , $userGroup['UserGroup']['id'])); ?>&nbsp;</td>
		<td><?php echo $userGroup['UserGroup']['description']; ?>&nbsp;</td>
		<td><?php echo $userGroup['Creator']['username']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $userGroup['UserGroup']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $userGroup['UserGroup']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $userGroup['UserGroup']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $userGroup['UserGroup']['id'])); ?>
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
		'heading' => 'User Groups',
		'items' => array(
			$this->Html->link(__('New User Group', true), array('action' => 'add')),
			)
		),
	)));
?>
<div class="userGroupWallPosts index">
	<h2><?php __('User Group Wall Posts');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('post');?></th>
			<th><?php echo $this->Paginator->sort('user_group_id');?></th>
			<th><?php echo $this->Paginator->sort('creator');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modifier');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($userGroupWallPosts as $userGroupWallPost):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $userGroupWallPost['UserGroupWallPost']['id']; ?>&nbsp;</td>
		<td><?php echo $userGroupWallPost['UserGroupWallPost']['post']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($userGroupWallPost['UserGroup']['title'], array('controller' => 'user_groups', 'action' => 'view', $userGroupWallPost['UserGroup']['id'])); ?>
		</td>
		<td><?php echo $userGroupWallPost['UserGroupWallPost']['creator']; ?>&nbsp;</td>
		<td><?php echo $userGroupWallPost['UserGroupWallPost']['created']; ?>&nbsp;</td>
		<td><?php echo $userGroupWallPost['UserGroupWallPost']['modifier']; ?>&nbsp;</td>
		<td><?php echo $userGroupWallPost['UserGroupWallPost']['modified']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $userGroupWallPost['UserGroupWallPost']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $userGroupWallPost['UserGroupWallPost']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $userGroupWallPost['UserGroupWallPost']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $userGroupWallPost['UserGroupWallPost']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New User Group Wall Post', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List User Groups', true), array('controller' => 'user_groups', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User Group', true), array('controller' => 'user_groups', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="userfollowers index">
	<h2><?php echo __('User followers');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('user_id');?></th>
			<th><?php echo $this->Paginator->sort('follower_id');?></th>
			<th><?php echo $this->Paginator->sort('approved');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php


	foreach ($userfollowers as $k => $userfollower):
		$class = (($k % 2)==0) ? ' class="altrow"' : '';

	?>
	<tr<?php echo $class;?>>
		<td><?php echo $userfollower['UserFollower']['id']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($userfollower['User']['username'], array('controller' => 'users', 'action' => 'view', $userfollower['User']['id'])); ?>
		</td>
		<td><?php echo $this->Html->link($userfollower['UserRef']['username'],array('controller' => 'users', 'action' => 'view', $userfollower['UserRef']['id'])); ?>&nbsp;</td>
		<td><?php echo $userfollower['UserFollower']['approved'] == 1 ? 'Yes' : 'No'; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $userfollower['UserFollower']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $userfollower['UserFollower']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $userfollower['UserFollower']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $userfollower['Userfollower']['id'])); ?>
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
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New User follower', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>

<div class="userWalls index">
	<h2><?php __('User Walls');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('post');?></th>
			<th><?php echo $this->Paginator->sort('creator_id');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($userWalls as $userWall):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $userWall['UserWall']['id']; ?>&nbsp;</td>
		<td><?php echo $userWall['UserWall']['post']; ?>&nbsp;</td>
		<td><?php echo $userWall['UserWall']['creator_id']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $userWall['UserWall']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $userWall['UserWall']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $userWall['UserWall']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $userWall['UserWall']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New User Wall', true), array('action' => 'add')); ?></li>
	</ul>
</div>
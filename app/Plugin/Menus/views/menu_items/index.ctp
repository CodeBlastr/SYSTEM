<div class="menus index">
	<h2><?php echo __('Menu Items');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('parent_id');?></th>
			<th><?php echo $this->Paginator->sort('item_text');?></th>
			<th><?php echo $this->Paginator->sort('item_url');?></th>
			<th><?php echo $this->Paginator->sort('order');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($menuItems as $menuItem):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $menuItem['MenuItem']['id']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($menuItem['Menu']['name'], array('controller' => 'menus', 'action' => 'view', $menuItem['Menu']['id'])); ?>
            <?php #debug($menuItem['ChildMenuItem']); ?>
		</td>
		<td><?php echo $menuItem['MenuItem']['item_text']; ?>&nbsp;</td>
		<td><?php echo $menuItem['MenuItem']['item_url']; ?>&nbsp;</td>
		<td><?php echo $menuItem['MenuItem']['order']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $menuItem['MenuItem']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $menuItem['MenuItem']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $menuItem['MenuItem']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $menuItem['MenuItem']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Menu Item', true), array('action' => 'add', $this->request->params['pass'][0])); ?></li>
		<li><?php echo $this->Html->link(__('View Parent Menu', true), array('controller' => 'menus', 'action' => 'view', $this->request->params['pass'][0])); ?> </li>
	</ul>
</div>
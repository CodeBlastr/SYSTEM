<div class="menus index">
	<h2><?php echo __('Menus');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('type');?></th>
			<th><?php echo $this->Paginator->sort('order');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($menus as $menu):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $menu['WebpageMenu']['id']; ?>&nbsp;</td>
		<td><?php echo $menu['WebpageMenu']['name']; ?>&nbsp;</td>
		<td><?php echo $menu['WebpageMenu']['type']; ?>&nbsp;</td>
		<td><?php echo $menu['WebpageMenu']['order']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $menu['WebpageMenu']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $menu['WebpageMenu']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $menu['WebpageMenu']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $menu['WebpageMenu']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Menu', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Menus', true), array('controller' => 'webpage_menus', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('List Menu Items', true), array('controller' => 'webpage_menu_items', 'action' => 'index')); ?> </li>
	</ul>
</div>
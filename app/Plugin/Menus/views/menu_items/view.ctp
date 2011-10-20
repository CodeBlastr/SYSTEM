<div class="menus view">
<h2><?php  __('MenuItem');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Menu'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($menuItem['Menu']['name'], array('controller' => 'menus', 'action' => 'view', $menuItem['Menu']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Item Text'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $menuItem['MenuItem']['item_text']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Item Url'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $menuItem['MenuItem']['item_url']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Order'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $menuItem['MenuItem']['order']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Menu', true), array('action' => 'edit', $menuItem['MenuItem']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Menu', true), array('action' => 'delete', $menuItem['MenuItem']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $menuItem['MenuItem']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Menus', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Menu', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Menus', true), array('controller' => 'menus', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Parent Menu', true), array('controller' => 'menus', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Creator', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Child Items');?></h3>
	<?php if (!empty($menuItem['ChildMenuItem'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Item Text'); ?></th>
		<th><?php echo __('Item Url'); ?></th>
		<th><?php echo __('Order'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($menuItem['ChildMenuItem'] as $childMenu):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $childMenu['id'];?></td>
			<td><?php echo $childMenu['item_text'];?></td>
			<td><?php echo $childMenu['item_url'];?></td>
			<td><?php echo $childMenu['order'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'menus', 'action' => 'view', $childMenu['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'menus', 'action' => 'edit', $childMenu['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'menus', 'action' => 'delete', $childMenu['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $childMenu['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Child Item', true), array('controller' => 'menus', 'action' => 'add', $menuItem['MenuItem']['menu_id'], $menuItem['MenuItem']['id']));?> </li>
		</ul>
	</div>
</div>

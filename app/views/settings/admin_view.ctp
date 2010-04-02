<div class="settings view">
<h2><?php  __('Setting');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $setting['Setting']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Key'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $setting['Setting']['key']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Value'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $setting['Setting']['value']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $setting['Setting']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $setting['Setting']['modified']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit Setting', true), array('action' => 'edit', $setting['Setting']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete Setting', true), array('action' => 'delete', $setting['Setting']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $setting['Setting']['id'])); ?> </li>
		<li><?php echo $html->link(__('List Settings', true), array('action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Setting', true), array('action' => 'add')); ?> </li>
	</ul>
</div>

<div class="wikiContents view">
<h2><?php  __('WikiContent');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $wikiContent['WikiContent']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Text'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $wikiContent['WikiContent']['text']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Comments'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $wikiContent['WikiContent']['comments']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Version'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $wikiContent['WikiContent']['version']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Wiki Page'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($wikiContent['WikiPage']['title'], array('controller' => 'wiki_pages', 'action' => 'view', $wikiContent['WikiPage']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Creator'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($wikiContent['Creator']['username'], array('controller' => 'users', 'action' => 'view', $wikiContent['Creator']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modifier'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($wikiContent['Modifier']['username'], array('controller' => 'users', 'action' => 'view', $wikiContent['Modifier']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $wikiContent['WikiContent']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $wikiContent['WikiContent']['modified']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit WikiContent', true), array('action' => 'edit', $wikiContent['WikiContent']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete WikiContent', true), array('action' => 'delete', $wikiContent['WikiContent']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $wikiContent['WikiContent']['id'])); ?> </li>
		<li><?php echo $html->link(__('List WikiContents', true), array('action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New WikiContent', true), array('action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('List Wiki Pages', true), array('controller' => 'wiki_pages', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Wiki Page', true), array('controller' => 'wiki_pages', 'action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Creator', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>

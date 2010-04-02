<div class="blogs view">
<h2><?php  __('Blog');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $blog['Blog']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Title'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $blog['Blog']['title']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Start Page'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $blog['Blog']['start_page']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Public'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $blog['Blog']['public']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('User'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($blog['User']['id'], array('controller' => 'users', 'action' => 'view', $blog['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $blog['Blog']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $blog['Blog']['modified']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit Blog', true), array('action' => 'edit', $blog['Blog']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete Blog', true), array('action' => 'delete', $blog['Blog']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $blog['Blog']['id'])); ?> </li>
		<li><?php echo $html->link(__('List Blogs', true), array('action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Blog', true), array('action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New User', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('List Blog Posts', true), array('controller' => 'blog_posts', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Blog Post', true), array('controller' => 'blog_posts', 'action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('List Blog User Groups', true), array('controller' => 'blog_user_groups', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Blog User Group', true), array('controller' => 'blog_user_groups', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Blog Posts');?></h3>
	<?php if (!empty($blog['BlogPost'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Title'); ?></th>
		<th><?php __('Introduction'); ?></th>
		<th><?php __('Text'); ?></th>
		<th><?php __('Seo Title'); ?></th>
		<th><?php __('Seo Keywords'); ?></th>
		<th><?php __('Seo Descriptions'); ?></th>
		<th><?php __('Public'); ?></th>
		<th><?php __('User Id'); ?></th>
		<th><?php __('Blog Id'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($blog['BlogPost'] as $blogPost):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $blogPost['id'];?></td>
			<td><?php echo $blogPost['title'];?></td>
			<td><?php echo $blogPost['introduction'];?></td>
			<td><?php echo $blogPost['text'];?></td>
			<td><?php echo $blogPost['seo_title'];?></td>
			<td><?php echo $blogPost['seo_keywords'];?></td>
			<td><?php echo $blogPost['seo_descriptions'];?></td>
			<td><?php echo $blogPost['public'];?></td>
			<td><?php echo $blogPost['user_id'];?></td>
			<td><?php echo $blogPost['blog_id'];?></td>
			<td><?php echo $blogPost['created'];?></td>
			<td><?php echo $blogPost['modified'];?></td>
			<td class="actions">
				<?php echo $html->link(__('View', true), array('controller' => 'blog_posts', 'action' => 'view', $blogPost['id'])); ?>
				<?php echo $html->link(__('Edit', true), array('controller' => 'blog_posts', 'action' => 'edit', $blogPost['id'])); ?>
				<?php echo $html->link(__('Delete', true), array('controller' => 'blog_posts', 'action' => 'delete', $blogPost['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $blogPost['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $html->link(__('New Blog Post', true), array('controller' => 'blog_posts', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php __('Related Blog User Groups');?></h3>
	<?php if (!empty($blog['BlogUserGroup'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Blog Id'); ?></th>
		<th><?php __('User Group Id'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($blog['BlogUserGroup'] as $blogUserGroup):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $blogUserGroup['id'];?></td>
			<td><?php echo $blogUserGroup['blog_id'];?></td>
			<td><?php echo $blogUserGroup['user_group_id'];?></td>
			<td><?php echo $blogUserGroup['created'];?></td>
			<td><?php echo $blogUserGroup['modified'];?></td>
			<td class="actions">
				<?php echo $html->link(__('View', true), array('controller' => 'blog_user_groups', 'action' => 'view', $blogUserGroup['id'])); ?>
				<?php echo $html->link(__('Edit', true), array('controller' => 'blog_user_groups', 'action' => 'edit', $blogUserGroup['id'])); ?>
				<?php echo $html->link(__('Delete', true), array('controller' => 'blog_user_groups', 'action' => 'delete', $blogUserGroup['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $blogUserGroup['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $html->link(__('New Blog User Group', true), array('controller' => 'blog_user_groups', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>

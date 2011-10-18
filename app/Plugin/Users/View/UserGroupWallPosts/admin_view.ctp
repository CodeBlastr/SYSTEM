<div class="userGroupWallPosts view">
<h2><?php  __('User Group Wall Post');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $userGroupWallPost['UserGroupWallPost']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Post'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $userGroupWallPost['UserGroupWallPost']['post']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('User Group'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($userGroupWallPost['UserGroup']['title'], array('controller' => 'user_groups', 'action' => 'view', $userGroupWallPost['UserGroup']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Creator'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $userGroupWallPost['UserGroupWallPost']['creator']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $userGroupWallPost['UserGroupWallPost']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modifier'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $userGroupWallPost['UserGroupWallPost']['modifier']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $userGroupWallPost['UserGroupWallPost']['modified']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit User Group Wall Post', true), array('action' => 'edit', $userGroupWallPost['UserGroupWallPost']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete User Group Wall Post', true), array('action' => 'delete', $userGroupWallPost['UserGroupWallPost']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $userGroupWallPost['UserGroupWallPost']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List User Group Wall Posts', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User Group Wall Post', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List User Groups', true), array('controller' => 'user_groups', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User Group', true), array('controller' => 'user_groups', 'action' => 'add')); ?> </li>
	</ul>
</div>

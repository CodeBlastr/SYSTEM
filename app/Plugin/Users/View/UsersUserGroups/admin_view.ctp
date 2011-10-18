<div class="UsersUserGroups view">
<h2><?php  __('Users User Goup');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $usersUserGroup['UsersUserGroup']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('User'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($usersUserGroup['User']['username'], array('controller' => 'users', 'action' => 'view', $usersUserGroup['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('User Group'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($usersUserGroup['UserGroup']['title'], array('controller' => 'user_groups', 'action' => 'view', $usersUserGroup['UserGroup']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Approved'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $usersUserGroup['UsersUserGroup']['is_approved']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Moderator'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $usersUserGroup['UsersUserGroup']['is_moderator']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Users User Goup', true), array('action' => 'edit', $usersUserGroup['UsersUserGroup']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Users User Goup', true), array('action' => 'delete', $usersUserGroup['UsersUserGroup']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $usersUserGroup['UsersUserGroup']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Users User Goups', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Users User Goup', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List User Groups', true), array('controller' => 'user_groups', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User Group', true), array('controller' => 'user_groups', 'action' => 'add')); ?> </li>
	</ul>
</div>

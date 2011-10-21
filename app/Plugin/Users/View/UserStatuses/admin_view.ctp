<div class="userStatuses view">
<h2><?php  __('User Status');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $userStatus['UserStatus']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Status'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $userStatus['UserStatus']['status']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Creator Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $userStatus['UserStatus']['creator_id']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit User Status', true), array('action' => 'edit', $userStatus['UserStatus']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete User Status', true), array('action' => 'delete', $userStatus['UserStatus']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $userStatus['UserStatus']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List User Statuses', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User Status', true), array('action' => 'add')); ?> </li>
	</ul>
</div>

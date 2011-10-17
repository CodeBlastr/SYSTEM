<div class="userfollowers view">
<h2><?php  __('User follower');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $userfollower['Userfollower']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('User'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($userfollower['User']['username'], array('controller' => 'users', 'action' => 'view', $userfollower['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Followed Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $userfollower['Userfollower']['follower_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Approved'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $userfollower['Userfollower']['approved']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit User follower', true), array('action' => 'edit', $userfollower['Userfollower']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete User follower', true), array('action' => 'delete', $userfollower['Userfollower']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $userfollower['Userfollower']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List User followers', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User follower', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>

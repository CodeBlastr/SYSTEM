<div class="userWalls view">
<h2><?php  __('User Wall');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $userWall['UserWall']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Post'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $userWall['UserWall']['post']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Creator Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $userWall['UserWall']['creator_id']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit User Wall', true), array('action' => 'edit', $userWall['UserWall']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete User Wall', true), array('action' => 'delete', $userWall['UserWall']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $userWall['UserWall']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List User Walls', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User Wall', true), array('action' => 'add')); ?> </li>
	</ul>
</div>

<div class="userRoles view">
<h2><?php  __('UserRole');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $userRole['UserRole']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $userRole['UserRole']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $userRole['UserRole']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $userRole['UserRole']['modified']; ?>
			&nbsp;
		</dd>
	</dl>
</div>

<?php 
// set the contextual menu items
$this->Menu->setValue(array(
	array(
		'heading' => 'User Roles',
		'items' => array(
			 $this->Html->link(__('Edit UserRole', true), array('action' => 'edit', $userRole['UserRole']['id'])),
			 $this->Html->link(__('Delete UserRole', true), array('action' => 'delete', $userRole['UserRole']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $userRole['UserRole']['id'])),
			 $this->Html->link(__('List UserRoles', true), array('action' => 'index')),
			 $this->Html->link(__('New UserRole', true), array('action' => 'add')),
			 )
		),
	array(
		'heading' => 'Users',
		'items' => array(
			 $this->Html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')),
			 )
		),
	));
?>

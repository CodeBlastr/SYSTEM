<div class="userRoles index">
  <h2><?php echo __('User Roles');?></h2>
  <table cellpadding="0" cellspacing="0">
    <tr>
      <th><?php echo $this->Paginator->sort('id');?></th>
      <th><?php echo $this->Paginator->sort('name');?></th>
      <th><?php echo $this->Paginator->sort('view_prefix');?></th>
      <th class="actions"><?php echo __('Actions');?></th>
    </tr>
    <?php
$i = 0;
foreach ($userRoles as $userRole):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
    <tr<?php echo $class;?>>
      <td><?php echo $userRole['UserRole']['id']; ?></td>
      <td><?php echo $userRole['UserRole']['name']; ?></td>
      <td><?php echo $userRole['UserRole']['view_prefix']; ?></td>
      <td class="actions"><?php echo $this->Html->link(__('View', true), array('action' => 'view', $userRole['UserRole']['id'])); ?> <?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $userRole['UserRole']['id'])); ?> <?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $userRole['UserRole']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $userRole['UserRole']['id'])); ?></td>
    </tr>
    <?php endforeach; ?>
  </table>
</div>
<?php echo $this->Element('paging'); ?>
<?php 
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'User Roles',
		'items' => array(
			 $this->Html->link(__('Add User Role', true), array('action' => 'add')),
			 )
		),
	array(
		'heading' => 'Users',
		'items' => array(
			 $this->Html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')),
			 )
		),
	)));
?>

<div class="users index">
  <h2><?php echo __('Users');?></h2>
  <table cellpadding="0" cellspacing="0">
    <tr>
      <th><?php echo $this->Paginator->sort('username');?></th>
      <th class="actions"><?php echo __('Actions');?></th>
    </tr>
    <?php
$i = 0;
foreach ($users as $user):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
    <tr<?php echo $class;?>>
      <td><?php echo $this->Element('snpsht', array('useGallery' => true, 'userId' => $user['User']['id'], 'thumbSize' => 'small', 'thumbLink' => '/users/users/view/'.$user['User']['id']));  ?> <?php echo $user['User']['username']; ?></td>
      <td class="actions"><?php echo $this->Html->link(__('View', true), array('action' => 'view', $user['User']['id'])); ?></td>
    </tr>
    <?php endforeach; ?>
  </table>
</div>
<?php echo $this->Element('paging'); ?>
<?php 
// set the contextual menu items
echo $this->Element('context_menu', array('menus' => array(
	array(
		'heading' => 'Users',
		'items' => array(
			 $this->Html->link(__('New User', true), array('action' => 'register')),
			 )
		),
	array(
		'heading' => 'User Roles',
		'items' => array(
			 $this->Html->link(__('List User Roles', true), array('controller' => 'user_roles', 'action' => 'index')),
			 )
		),
	)));
?>

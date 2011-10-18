<div id="users-view" class="users view">
  <div id="user-information">
    <h2><?php echo $user['User']['first_name'] . ' ' . $user['User']['last_name'] ?></h2>
    <?php #echo $this->element('snpsht', array('useGallery' => true, 'userId' => $user['User']['id'], 'thumbSize' => 'medium', 'thumbLink' => 'default'));  ?>
  </div>
</div>
<div id="follow action">
  <?php if($does_follow):?>
  <p>
    <?php __('You currently follow this user.'); ?>
  </p>
  <p><?php echo count($followers); __('Followers'); ?></p>
  <?php elseif(!$is_self): ?>
  <p><?php echo $this->Html->link('Follow This User' , array('plugin' => 'users' , 'controller' => 'user_followers' , 'action'=>'add' , $uid));?></p>
  <?php endif;?>
</div>
<div id="status-detail" class="list">
  <?php if(count($statuses) != 0):?>
  <ul>
    <?php foreach($statuses as $status):?>
    <li><?php echo $status['User']['username']; __(' wrote: '); echo $status['UserStatus']['status']; __(' ...'); echo $this->Time->niceShort($status['UserStatus']['created']); ?></li>
    <?php endforeach;?>
    <?php endif;?>
  </ul>
</div>
<?php /* This needs a setting to turn on or off
if($is_self):?>
<div id="status-add" class="form">
<?php 
	echo $this->Form->create('UserStatus', array('action' => 'add'));
	echo $this->Form->input('UserStatus.status', array('type' => 'text'));
	echo $this->Form->input('UserStatus.user_id', array('type' => 'hidden', 'value' => $user['User']['id']));
	echo $this->Form->end('Update');
?>
</div>
<?php endif;*/ ?>
<?php if(count($walls) != 0):?>
<h3>Wall</h3>
<table>
  <?php foreach($walls as $w):?>
  <tr>
    <td><?php echo $w['UserWall']['post']?></td>
    <td><?php echo $this->Html->link($w['Owner']['username'] , array('plugin'=>'users','controller'=>'users' , 'action'=>'view' , 'user_id'=>$w['Owner']['id']))?></td>
  </tr>
  <?php endforeach;?>
  <?php endif;?>
</table>
<?php 
if($is_self):
	$messageBoardLink = $this->Html->link('View Message Board' , array('plugin'=>'messages' ,'controller'=>'messages', 'action'=>'index'), array('checkPermissions' => true));
else:
	$messageBoardLink = $this->Html->link('Send a Message To This User' , array('plugin'=>'messages', 'controller'=>'messages' , 'action'=>'add' , $user['User']['username']), array('checkPermissions' => true));
endif;
?>
<?php 
foreach ($followedUsers as $followedUser) {
	echo '<a href="/users/users/view/'.$followedUser['UserFollower']['user_id'].'">Friend</a><br>';
}
?>
<?php 
/*
This menu needs a lot of work.  I'm not sure how to handle it, and its important
because it is different for every single site.  */
// set the contextual menu items
echo $this->Element('context_menu', array('menus' => array(
	array(
		'heading' => 'Users',
		'items' => array(
			/*$this->Html->link(__('List Users', true), array('action' => 'index'), array('checkPermissions' => true)),*/
			$this->Html->link(__('Edit User', true), array('action' => 'edit', $user['User']['id']), array('checkPermissions' => true)),
			/*$this->Html->link('Add Wall Post' , array('plugin'=>'users', 'controller'=>'user_walls' , 'action'=>'add' , $uid), array('checkPermissions' => true)),
			$messageBoardLink,*/
			),
		),
	/*array(
		'heading' => 'Groups',
		'items' => array(
			$this->Html->link(__('Create Group', true), array('controller' => 'user_groups', 'action' => 'add'), array('checkPermissions' => true)),
			)
		),
	array(
		'heading' => 'Galleries',
		'items' => array(
			#commented out because we have a use case which is not accounted for... where index for example 
			# has permissions, but galleries for this particular user are not. 
			#$this->Html->link(__('List Galleries', true), array('plugin' => 'galleries', 'controller' => 'galleries', 'action' => 'index', 'User', $user['User']['id']), array('checkPermissions' => true)),
			$this->Html->link(__('Add Gallery', true), array('plugin' => 'galleries', 'controller' => 'galleries', 'action' => 'add', 'User', $user['User']['id']), array('checkPermissions' => true)),
			)
		),
	array(
		'heading' => 'Blogs',
		'items' => array(
			#commented out because we have a use case which is not accounted for... where index for example 
			# has permissions, but galleries for this particular user are not. 
			#$this->Html->link(__('View Blog', true), array('plugin' => 'blogs', 'controller' => 'blogs', 'action' => 'view', 'user' => $user['User']['id']), array('checkPermissions' => true)),
			$this->Html->link(__('Create Blog', true), array('plugin' => 'blogs', 'controller' => 'blogs', 'action' => 'add'), array('checkPermissions' => true)),
			)
		), */
	)));
?>

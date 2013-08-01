<h2><?php echo $userGroup['UserGroup']['title']; ?> </h2>

<div class="user-groups-decription">
	<?php echo $userGroup['UserGroup']['description']; ?>
</div>
	<h3>Founder : <?php echo $this->Html->link($userGroup['Creator']['full_name'] . ' (' . $userGroup['Creator']['username'] . ')' , array('plugin' => 'users', 'controller' => 'users', 'action' => 'view', $userGroup['Creator']['id']))?></h3>
	 <p>Your Status For this Group:
	  	<?php
		if($status == 'moderator') {
			echo __('Moderator (%s)', $this->Html->link('Moderate Group' , array('plugin' => 'users', 'controller' => 'user_groups' , 'action' => 'edit', $userGroup['UserGroup']['id'])));			
		} else if ($status == 'approved') {
			echo __('Member');
		} else {
			echo __('Pending');
			echo $this->Html->link('Join', array('plugin'=>'users', 'controller'=>'user_groups' , 'action'=>'join' , $user['UsersUserGroup']['id']), array('class' => 'btn btn-primary pull-right'));
		} ?>
    </p>
	<table>
	  <tr>
	    <th>Users in this group</th>
	    <th>Status</th>
		<?php if ($status == 'moderator') { ?>
        <th> <?php echo __('Action'); ?> </th>
        <?php } ?>
	  </tr>
	  <?php foreach($userGroup['User'] as $user):?>
		  <tr>
		    <td><?php echo $this->Element('thumb', array('model' => 'User', 'foreignKey' => $user['id'], 
'thumbSize' => 'small', 'thumbLink' => '/users/users/view/'.$user['id']), array('plugin' => 'galleries')); echo $this->Html->link($user['full_name'], array('plugin'=>'users','controller' => 'users' , 'action'=>'view' , $user['id']))?></td>
		    <td>	
	  			<?php
				if($user['UsersUserGroup']['is_moderator'] == 1) {
					echo __('Moderator');
				} else if ($user['UsersUserGroup']['is_approved'] == 1) {
					echo __('Member');
				} else {
					echo __('Pending');
				} ?>
		    </td>
            <td>
			<?php
			if ($status == 'moderator') {
				echo $this->Html->link('Edit' , array('plugin' => 'users', 'controller' => 'users_user_groups' , 'action' => 'edit', $user['UsersUserGroup']['id']));
				echo ' ';
				echo $this->Html->link('Remove' , array('plugin' => 'users', 'controller' => 'users_user_groups' , 'action' => 'delete', $user['UsersUserGroup']['id']));
			} else if ($status == 'approved') {
				# maybe add a post link or something
			} else {
//				echo $this->Html->link('Join', array('plugin'=>'users', 'controller'=>'user_groups' , 'action'=>'join' , $user['UsersUserGroup']['id']));
			}?>
            </td>
		  </tr>
	  <?php endforeach;?>
	</table>
	
    
	<table>
	  <tr>
	    <th>Group Wall</th>
	  </tr>
	  <?php foreach($userGroup['UserGroupWallPost'] as $pgwp) { //debug($pgwp); ?>
		  <tr>
		    <td><?php echo $this->Element('snpsht', array('plugin' => 'users', 'id' => $pgwp['Creator']['id'], 'showFirstName' => true, 'showLastName' => true)); ?></td>
		    <td>
				<?php
				echo $pgwp['post']
						.' <div class="createdDate"><small>posted '.$this->Time->niceShort($pgwp['created']).'</small></div>';
				
				foreach ( $pgwp['Comment'] as $comment ) {
					echo $this->Html->tag('div',
							'<hr />'.
							$comment['user_id'] . ' said: ' . $comment['body']
							. '<br /><small>' .$this->Time->niceShort($comment['created']). '</small>'
					);
				}
				
				echo $this->Form->create('Comment', array('url' => '/comments/comments/add'))
				. $this->Form->hidden('user_id', array('value' => $this->Session->read('Auth.User.id')))
				. $this->Form->hidden('model', array('value' => 'UserGroupWallPost'))
				. $this->Form->hidden('foreign_key', array('value' => $pgwp['id']))
				. $this->Form->input('body', array('label' => false, 'placeholder' => 'Add a comment...'))
				. $this->Form->submit('Add Comment', array('class' => 'btn-mini'));
				?>
			</td>
		   </tr>
		   
	  <?php
//		echo $this->Form->create('Comment')
//			. $this->Form->hidden('user_id', array('value' => $this->userId))
//			. $this->Form->hidden('model', array('value' => 'UserGroupWallPost'))
//			. $this->Form->hidden('foreign_key', array('value' => $pgwp['id']))
//			. $this->Form->input('body')
////			echo $this->Form->input('approved');
//			. $this->Form->submit('save');
	  }
	  ?>
	</table>

	<?php echo $this->Html->link('Post To Group Wall' , array('plugin'=>'users','controller'=>'user_group_wall_posts' , 'action'=>'add', $this->request->params['pass'][0]),  array('class' => 'btn'))?>
	<?php #echo $this->Html->link('Join This Group' , array('plugin'=>'users','controller'=>'users_user_groups' , 'action'=>'add', $userGroup['UserGroup']['id'] , $userId ));?>
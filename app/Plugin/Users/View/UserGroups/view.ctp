<h2><?php echo $userGroup['UserGroup']['title']; ?></h2>

<div class="user-groups-decription">
	<?php echo $userGroup['UserGroup']['description']; ?>
</div>
	<h3>Founder : <?php echo $this->Html->link($userGroup['Creator']['full_name'] . ' (' . $userGroup['Creator']['username'] . ')' , array('plugin' => 'users', 'controller' => 'users', 'action' => 'view', $userGroup['Creator']['id']))?></h3>
	 <p>Your Status For this Group:
	 			<?php if($u_dat['UsersUserGroup']['is_moderator'] == 1):?>
		    		Moderator
		    	<?php elseif($u_dat['UsersUserGroup']['is_approved'] == 1):?>
		    		Member
		    	<?php else:?>
		    		Pending Approval
		    	<?php endif;?>	
	</p>
	<table>
	  <tr>
	    <th>Users in this group</th>
	    <th>Status</th>
        <?php if($u_dat['UsersUserGroup']['is_moderator'] == 1):?>
        <th>
          Action
        </th>
        <?php endif; ?>
	  </tr>
	  <?php foreach($userGroup['User'] as $user):?>
		  <tr>
		    <td><?php echo $this->Element('thumb', array('model' => 'User', 'foreignKey' => $user['id'], 
'thumbSize' => 'small', 'thumbLink' => '#'), array('plugin' => 'galleries')); echo $this->Html->link($user['full_name'] . ' (' . $user['username'] . ')', array('plugin'=>'users','controller' => 'users' , 'action'=>'view' , $user['id']))?></td>
		    <td>	
	  			<?php if($user['UsersUserGroup']['is_moderator'] == 1):?>
		    		Moderator
		    	<?php elseif($user['UsersUserGroup']['is_approved'] == 1):?>
		    		Member
		    	<?php else:?>
		    		Pending
		    	<?php endif;?>
		    </td>
            <?php if($u_dat['UsersUserGroup']['is_moderator'] == 1):?>
            <td><?php echo $this->Html->link('Edit', array('plugin'=>'users','controller'=>'users_user_groups' , 'action'=>'edit' , $user['UsersUserGroup']['id']))?></td>
            <?php endif; ?>
		  </tr>
	  <?php endforeach;?>
	</table>
	
    
	<?php /*<table>
	  <tr>
	    <th>Group Wall</th>
	  </tr>
	  <?php foreach($userGroup['UserGroupWallPost'] as $pgwp):?>
		  <tr>
		    <td><?php echo $this->Element('snpsht', array('plugin' => 'users', 'id' => $pgwp['Creator']['id'])); ?></td>
		    <td><?php echo $pgwp['post'].' <span class="createdDate">on '.$pgwp['created'].'</span>'; ?></td>
		   </tr>
	  <?php endforeach;?>
	</table> */ ?>

	<?php #echo $this->Html->link('Post To Group Wall' , array('plugin'=>'users','controller'=>'user_group_wall_posts' , 'action'=>'add', $this->request->params['pass'][0]))?>
	<?php #echo $this->Html->link('Join This Group' , array('plugin'=>'users','controller'=>'users_user_groups' , 'action'=>'add', $userGroup['UserGroup']['id'] , $userId ));?>
	<?php echo $this->Html->link('Add Members to this Group' , array('plugin'=>'users','controller'=>'users_user_groups' , 'action'=>'add'));?>
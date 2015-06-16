<h2><?php echo $userGroup['UserGroup']['title']; ?> </h2>

<div class="user-groups-decription">
	<?php echo $userGroup['UserGroup']['description']; ?>
</div>
	<h3>Founder : <?php echo $this->Html->link($userGroup['Creator']['full_name'] . ' (' . $userGroup['Creator']['username'] . ')' , array('plugin' => 'users', 'controller' => 'users', 'action' => 'view', $userGroup['Creator']['id']))?></h3>
	 <p>Your Status For this Group:
	  	<?php
		if ($status == 'moderator') {
			echo __('Moderator (%s)', $this->Html->link('Moderate Group', array(
				'plugin' => 'users',
				'controller' => 'user_groups',
				'action' => 'edit',
				$userGroup['UserGroup']['id']
			)));
		} else if ($status == 'approved') {
			echo __('Member');
		} else if ($status == 'pending') {
			echo __('Pending');
		} else {
			echo __('Unaffiliated');
			echo $this->Html->link('Join', array(
				'plugin' => 'users',
				'controller' => 'user_groups',
				'action' => 'join',
				$userGroup['UserGroup']['id']
					), array('class' => 'btn btn-primary pull-right'));
		}
 ?>
    </p>
	
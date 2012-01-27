<div class="userGroups form">
<?php echo $this->Form->create('UserGroup');?>
	<fieldset>
 		<legend><?php echo __('Edit User Group'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('title');
		echo $this->Form->input('description');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>

<div class="UsersUserGroups form"> 
 <?php echo $this->Form->create('UsersUserGroup', array('url' => '/users/users_user_groups/add/'));?>
  <fieldset>
    <legend>
    <?php echo __('User administration'); ?>
    </legend>
    <?php
	 echo $this->Form->input('UsersUserGroup.user_id', array('label' => 'Add this user...'));
	 echo $this->Form->hidden('user_group_id', array('value' => $this->request->data['UserGroup']['id']));
	?>
    <legend>
    <?php echo __('What is the user\'s status in this group?'); ?>
    </legend>
    <?php 
	 echo $this->Form->input('UsersUserGroup.is_approved', array('type' => 'checkbox'));
	 echo $this->Form->input('UsersUserGroup.is_moderator', array('type' => 'checkbox'));
	?>
  </fieldset>
 <?php echo $this->Form->end(__('Submit'));?>
</div>



<?php 
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Groups',
		'items' => array(
			$this->Html->link(__('List Groups', true), array('action' => 'index')),
			$this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('UserGroup.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('UserGroup.id'))),
			$this->Html->link(__('All Users', true), array('action' => 'index'), array('class' => 'index')),
			$this->Html->link(__('Add Group', true), array('controller' => 'user_groups', 'action' => 'add'), array('class' => 'add')),
			)
		),
	)));
?>
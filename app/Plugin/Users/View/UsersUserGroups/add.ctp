<div class="UsersUserGroups form"> 
 <?php echo $this->Form->create('UsersUserGroup');?>
  <fieldset>
    <legend>
    <?php echo __('User administration form'); ?>
    </legend>
    <?php
	 echo $this->Form->input('user_id', array('label' => 'Add this user...'));
	 echo $this->Form->input('UsersUserGroup.user_group_id', array('label' => 'To this group...'));
	?>
  </fieldset>
  <fieldset>
    <legend>
    <?php echo __('What is the user\'s status in this group?'); ?>
    </legend>
    <?php 
	 echo $this->Form->input('is_approved');
	 echo $this->Form->input('is_moderator');
	?>
  </fieldset>
 <?php echo $this->Form->end(__('Submit', true));?>
</div>
  

<?php 
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Users, Groups',
		'items' => array(
			$this->Html->link(__('List Users', true), array('action' => 'index'), array('class' => 'index')),
			$this->Html->link(__('List Groups', true), array('controller' => 'user_groups', 'action' => 'index'), array('class' => 'index')),
			$this->Html->link(__('Add Group', true), array('controller' => 'user_groups', 'action' => 'add'), array('class' => 'add'))
			)
		),
	))); ?>
